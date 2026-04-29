<?php
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

$db = new InstruktoriDatabase();

// id přijde z GET při prokliku z výpisu, z POST při uložení formuláře.
$id = null;
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_POST['id'];
} elseif (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_GET['id'];
}

$message = '';
$instruktor = ($id !== null) ? $db->getById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $instruktor !== null) {
    $upraveny = new Instruktori();
    // Nezaškrtnutý checkbox v POSTu vůbec není, proto ternární s isset.
    $aktivni = isset($_POST['aktivni']) ? 1 : 0;

    $ok = $upraveny->nastavHodnoty(
        $id,
        $_POST['jmeno']    ?? '',
        $_POST['prijmeni'] ?? '',
        $_POST['telefon']  ?? '',
        $_POST['email']    ?? '',
        $aktivni
    );

    if ($ok === false) {
        $message = '<h2>Chyba: zadané hodnoty nejsou platné</h2>';
    } else {
        if ($db->update($upraveny)) {
            $message = '<h2>Data byla upravena</h2>';
            $instruktor = $db->getById($id);
        } else {
            $message = '<h2>Data nebyla upravena</h2>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Editace instruktora</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>

<body>
    <header>
        <h1>Editace instruktora</h1>
    </header>
    <main class="flex-main">
        <?php
        echo $message;

        if ($id === null) {
            echo "<p>Neplatné ID instruktora.</p>";
        } elseif ($instruktor === null) {
            echo "<p>Instruktor s ID " . htmlspecialchars((string)$id) . " nenalezen.</p>";
        } else {
        ?>
            <form method="post" class="styled-panel">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string)$instruktor->getId()) ?>">

                <label for="jmeno">Jméno</label>
                <input type="text" name="jmeno" maxlength="50"
                    value="<?= htmlspecialchars((string)$instruktor->getJmeno()) ?>" required>

                <label for="prijmeni">Příjmení</label>
                <input type="text" name="prijmeni" maxlength="50"
                    value="<?= htmlspecialchars((string)$instruktor->getPrijmeni()) ?>" required>

                <label for="telefon">Telefon</label>
                <input type="text" name="telefon" maxlength="20" placeholder="+420 123 456 789"
                    value="<?= htmlspecialchars((string)($instruktor->getTelefon() ?? '')) ?>">

                <label for="email">E-mail</label>
                <input type="text" name="email" maxlength="100"
                    value="<?= htmlspecialchars((string)($instruktor->getEmail() ?? '')) ?>">

                <label>
                    <input type="checkbox" name="aktivni" value="1" <?= $instruktor->getAktivni() ? 'checked' : '' ?>>
                    Aktivní
                </label>

                <button type="submit">Uložit změny</button>
            </form>
        <?php } ?>
        <p><a href="../forms_display/form-instruktori.php">Zpět na seznam</a></p>
    </main>
</body>

</html>