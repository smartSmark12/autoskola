<?php
require_once __DIR__ . "/studenti_db.php";
require_once __DIR__ . "/instruktori_db.php";

// Centrální autentizace přes PHP session.
// Role uživatele je dána tabulkou, ve které se najde email: 'student' | 'instruktor'.
class Auth {

    // Spustí session s rozumným zabezpečením cookie. Volat na začátku každé stránky.
    public static function start() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        session_set_cookie_params([
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    // Pokusí se přihlásit dle emailu a hesla. Vrací true při úspěchu.
    public static function login($email, $heslo) {
        self::start();

        // 1) zkus studenta
        $student = (new StudentiDatabase())->findByEmail($email);
        if ($student && self::overHeslo($heslo, $student['heslo'])) {
            self::nastavSession((int)$student['id'], 'student', $student['jmeno'], $student['prijmeni']);
            return true;
        }

        // 2) zkus instruktora
        $instruktor = (new InstruktoriDatabase())->findByEmail($email);
        if ($instruktor && self::overHeslo($heslo, $instruktor['heslo'])) {
            self::nastavSession((int)$instruktor['id'], 'instruktor', $instruktor['jmeno'], $instruktor['prijmeni']);
            return true;
        }

        return false;
    }

    private static function overHeslo($heslo, $hash) {
        return is_string($hash) && $hash !== '' && password_verify($heslo, $hash);
    }

    private static function nastavSession($id, $role, $jmeno, $prijmeni) {
        session_regenerate_id(true);
        $_SESSION['uzivatel'] = [
            'id'       => $id,
            'role'     => $role,
            'jmeno'    => $jmeno,
            'prijmeni' => $prijmeni,
        ];
        // zobraz varování o nebezpečném přihlášení – jen jednou, hned po přihlášení
        $_SESSION['zobraz_varovani'] = true;
    }

    public static function logout() {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function check() {
        self::start();
        return isset($_SESSION['uzivatel']);
    }

    public static function id() {
        return self::check() ? $_SESSION['uzivatel']['id'] : null;
    }

    public static function role() {
        return self::check() ? $_SESSION['uzivatel']['role'] : null;
    }

    public static function jeStudent() {
        return self::role() === 'student';
    }

    public static function jeInstruktor() {
        return self::role() === 'instruktor';
    }

    public static function jmeno() {
        return self::check() ? $_SESSION['uzivatel']['jmeno'] : '';
    }

    public static function prijmeni() {
        return self::check() ? $_SESSION['uzivatel']['prijmeni'] : '';
    }

    public static function celeJmeno() {
        return self::check()
            ? trim($_SESSION['uzivatel']['jmeno'] . ' ' . $_SESSION['uzivatel']['prijmeni'])
            : '';
    }

    // Guard: vyžaduje přihlášení, jinak přesměruje na login. $rel = cesta ke kořeni.
    public static function requireLogin($rel = '') {
        if (!self::check()) {
            header('Location: ' . $rel . 'login.php');
            exit;
        }
    }

    // Guard: vyžaduje roli instruktora, jinak přesměruje na úvod.
    public static function requireInstruktor($rel = '') {
        self::requireLogin($rel);
        if (!self::jeInstruktor()) {
            header('Location: ' . $rel . 'index.php');
            exit;
        }
    }
}
