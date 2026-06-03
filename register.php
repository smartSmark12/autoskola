<?php
require_once __DIR__ . "/framework/auth.php";
Auth::start();

if (Auth::check()) {
    header('Location: index.php');
    exit;
}

$chyba   = '';
$uspech  = '';
$old     = ['role' => 'student', 'jmeno' => '', 'prijmeni' => '', 'email' => '', 'datum_narozeni' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = ($_POST['role'] ?? 'student') === 'instruktor' ? 'instruktor' : 'student';
    $jmeno    = trim($_POST['jmeno'] ?? '');
    $prijmeni = trim($_POST['prijmeni'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $heslo    = $_POST['heslo'] ?? '';
    $heslo2   = $_POST['heslo2'] ?? '';
    $datumNar = trim($_POST['datum_narozeni'] ?? '');

    $old = compact('role', 'jmeno', 'prijmeni', 'email') + ['datum_narozeni' => $datumNar];

    if ($jmeno === '' || $prijmeni === '' || $email === '') {
        $chyba = 'Vyplňte jméno, příjmení i email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $chyba = 'Email nemá platný formát.';
    } elseif (mb_strlen($heslo) < 6) {
        $chyba = 'Heslo musí mít alespoň 6 znaků.';
    } elseif ($heslo !== $heslo2) {
        $chyba = 'Hesla se neshodují.';
    } elseif ($role === 'student' && $datumNar !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datumNar)) {
        $chyba = 'Datum narození nemá platný formát.';
    } else {
        // email musí být unikátní napříč oběma tabulkami
        $existuje = (new StudentiDatabase())->findByEmail($email)
                 || (new InstruktoriDatabase())->findByEmail($email);
        if ($existuje) {
            $chyba = 'Uživatel s tímto emailem už existuje.';
        } else {
            $hash = password_hash($heslo, PASSWORD_DEFAULT);
            if ($role === 'instruktor') {
                $newId = (new InstruktoriDatabase())->registruj($jmeno, $prijmeni, $email, $hash);
            } else {
                $newId = (new StudentiDatabase())->registruj(
                    $jmeno, $prijmeni, $datumNar === '' ? null : $datumNar, $email, $hash
                );
            }

            if ($newId) {
                Auth::login($email, $heslo);
                header('Location: index.php');
                exit;
            }
            $chyba = 'Registraci se nepodařilo dokončit.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace &mdash; autoškola</title>
    <link rel="shortcut icon" href="bordel/favicon.png" type="image/png">
    <link rel="stylesheet" href="bordel/style.css?v=<?= @filemtime(__DIR__ . '/bordel/style.css') ?: time() ?>">
</head>
<body class="auth-page">
    <div class="auth-infobar">
        <strong class="hl-blue">Registrace nového účtu.</strong>
        Vyberte, zda zakládáte účet <strong>žáka</strong> nebo <strong>instruktora</strong>, a vyplňte údaje.
        Email slouží jako přihlašovací jméno.<br>
        Už máte účet? <a href="login.php">Přihlaste se</a>.
    </div>

    <div class="auth-center">
        <form class="auth-box auth-box-wide" method="post" action="">
            <div class="auth-box-header">Registrace do systému</div>
            <div class="auth-box-body">
                <?php if ($chyba !== ''): ?>
                    <div class="msg-err"><?= htmlspecialchars($chyba) ?></div>
                <?php endif; ?>

                <div class="auth-row">
                    <label>Role:</label>
                    <span class="auth-roles">
                        <label class="auth-radio">
                            <input type="radio" name="role" value="student"
                                <?= $old['role'] === 'student' ? 'checked' : '' ?>
                                onchange="document.getElementById('row-narozeni').style.display = this.checked ? 'flex' : 'none';">
                            Žák
                        </label>
                        <label class="auth-radio">
                            <input type="radio" name="role" value="instruktor"
                                <?= $old['role'] === 'instruktor' ? 'checked' : '' ?>
                                onchange="document.getElementById('row-narozeni').style.display = 'none';">
                            Instruktor
                        </label>
                    </span>
                </div>

                <div class="auth-row">
                    <label for="jmeno">Jméno:</label>
                    <input type="text" name="jmeno" id="jmeno" value="<?= htmlspecialchars($old['jmeno']) ?>" required>
                </div>
                <div class="auth-row">
                    <label for="prijmeni">Příjmení:</label>
                    <input type="text" name="prijmeni" id="prijmeni" value="<?= htmlspecialchars($old['prijmeni']) ?>" required>
                </div>
                <div class="auth-row">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($old['email']) ?>" required>
                </div>
                <div class="auth-row" id="row-narozeni" style="<?= $old['role'] === 'instruktor' ? 'display:none;' : '' ?>">
                    <label for="datum_narozeni">Datum narození:</label>
                    <input type="date" name="datum_narozeni" id="datum_narozeni" value="<?= htmlspecialchars($old['datum_narozeni']) ?>">
                </div>
                <div class="auth-row">
                    <label for="heslo">Heslo:</label>
                    <input type="password" name="heslo" id="heslo" placeholder="alespoň 6 znaků" required>
                </div>
                <div class="auth-row">
                    <label for="heslo2">Heslo znovu:</label>
                    <input type="password" name="heslo2" id="heslo2" required>
                </div>
            </div>
            <div class="auth-box-footer">
                <button type="submit">Zaregistrovat</button>
            </div>
        </form>
    </div>

    <div class="auth-footer-brand">
        <div class="brand-logo">
            <span class="brand-word"><em>auto</em>škola</span><span class="brand-num">4</span>
        </div>
        <div class="brand-meta">
            <span>&copy; 2026&ndash;2026 1. řada</span>
            <span class="brand-ver">1.0</span>
        </div>
    </div>
</body>
</html>
