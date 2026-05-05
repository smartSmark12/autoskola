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
        $message = "<div class='msg-err'>Chyba: zadané hodnoty nejsou platné</div>";
    } else {
        if ($db->update($upraveny)) {
            $message = "<div class='msg-ok'>Data byla upravena</div>";
            $instruktor = $db->getById($id);
        } else {
            $message = "<div class='msg-err'>Data nebyla upravena</div>";
        }
    }
}

$pageTitle   = 'Editace instruktora';
$pageHeading = 'Editace instruktora';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

        <?php
        echo $message;

        if ($id === null) {
            echo "<div class='msg-err'>Neplatné ID instruktora.</div>";
        } elseif ($instruktor === null) {
            echo "<div class='msg-err'>Instruktor s ID " . htmlspecialchars((string)$id) . " nenalezen.</div>";
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
        <p class="back-link"><a href="../forms_display/form-instruktori.php">&laquo; Zpět na seznam</a></p>
<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>