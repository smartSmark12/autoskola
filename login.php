<?php
require_once __DIR__ . "/framework/auth.php";
Auth::start();

if (Auth::check()) {
    header('Location: index.php');
    exit;
}

$chyba = '';
$email = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $heslo = $_POST['heslo'] ?? '';

    if ($email === '' || $heslo === '') {
        $chyba = 'Vyplňte přihlašovací jméno i heslo.';
    } elseif (Auth::login($email, $heslo)) {
        header('Location: index.php');
        exit;
    } else {
        $chyba = 'Nesprávné přihlašovací jméno nebo heslo.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení &mdash; autoškola</title>
    <link rel="stylesheet" href="bordel/style.css?v=<?= @filemtime(__DIR__ . '/bordel/style.css') ?: time() ?>">
</head>
<body class="auth-page">
    <div class="auth-infobar">
        <p>
            <strong class="hl-blue">Autoškola je webová aplikace pro správu výuky a jízd.</strong>
            Během práce se <strong class="hl-red">nedoporučuje stránku aktualizovat</strong>, aby nedošlo ke ztrátě rozepsaných změn. Před odchodem z aplikace vždy uložte rozpracovaná data. <strong class="hl-red">Po dokončení práce se ze systému řádně odhlaste</strong>, zejména pokud používáte sdílený nebo školní počítač.
        </p>
        <p>
            Přihlášení je určeno pro administrátory, instruktory a oprávněné uživatele autoškoly. Přihlašovací údaje zadávejte pouze na této stránce.
        </p>
        <p>
            V systému lze evidovat <strong class="hl-blue">studenty, instruktory, auta a naplánované jízdy</strong>. Změny provádějte pečlivě, aby zůstala evidence aktuální.
        </p>
        <p>
            Pokud máte problém s přihlášením, zkontrolujte zadané jméno a heslo. V případě potíží kontaktujte <strong class="hl-blue">správce systému</strong>.
        </p>
    </div>

    <div class="auth-center">
        <form class="auth-box" method="post" action="">
            <div class="auth-box-header">Přihlášení do systému</div>
            <div class="auth-box-body">
                <?php if ($chyba !== ''): ?>
                    <div class="msg-err"><?= htmlspecialchars($chyba) ?></div>
                <?php endif; ?>
                <div class="auth-row">
                    <label for="email">Uživatel:</label>
                    <input type="text" name="email" id="email" placeholder="uživatelské jméno"
                           value="<?= htmlspecialchars($email) ?>" autofocus required>
                </div>
                <div class="auth-row">
                    <label for="heslo">Heslo:</label>
                    <input type="password" name="heslo" id="heslo" placeholder="heslo" required>
                </div>
            </div>
            <div class="auth-box-footer">
                <button type="submit">Přihlásit</button>
            </div>
        </form>
        <p class="auth-register-hint">Nový uživatel? <a href="register.php">Vytvořit účet</a>.</p>
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
