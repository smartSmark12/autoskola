<?php
require_once __DIR__ . "/../framework/studenti_db.php";
require_once __DIR__ . "/../clases/Studenti.php";

$db = new StudentiDatabase();

$id = null;
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_POST['id'];
} elseif (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_GET['id'];
}

$message = '';
$student = ($id !== null) ? $db->readStudent($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $student !== null) {
    $upraveny = new Studenti();
    $ok = $upraveny->nastavHodnoty(
        $_POST['jmeno']            ?? '',
        $_POST['prijmeni']         ?? '',
        $_POST['datum_narozeni']   ?? '',
        $_POST['telefon']          ?? '',
        $_POST['email']            ?? '',
        $_POST['datum_registrace'] ?? '',
        $id
    );

    if ($ok === false) {
        $message = "<div class='msg-err'>Chyba: zadané hodnoty nejsou platné</div>";
    } else {
        if ($db->update($upraveny)) {
            $message = "<div class='msg-ok'>Data byla upravena</div>";
            $student = $db->readStudent($id);
        } else {
            $message = "<div class='msg-err'>Data nebyla upravena</div>";
        }
    }
}

$pageTitle   = 'Editace studenta';
$pageHeading = 'Editace studenta';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

    <?php
    echo $message;

    if ($id === null) {
        echo "<div class='msg-err'>Neplatné ID studenta.</div>";
    } elseif ($student === null) {
        echo "<div class='msg-err'>Student s ID " . htmlspecialchars((string)$id) . " nenalezen.</div>";
    } else {
    ?>
        <form method="post" class="styled-panel">
            <input type="hidden" name="id" value="<?= htmlspecialchars((string)$student->getId()) ?>">

            <label for="jmeno">Jméno</label>
            <input type="text" name="jmeno" id="jmeno"
                   value="<?= htmlspecialchars((string)$student->get_jmeno()) ?>" required>

            <label for="prijmeni">Příjmení</label>
            <input type="text" name="prijmeni" id="prijmeni"
                   value="<?= htmlspecialchars((string)$student->get_prijmeni()) ?>" required>

            <label for="datum_narozeni">Datum narození</label>
            <input type="date" name="datum_narozeni" id="datum_narozeni"
                   value="<?= htmlspecialchars((string)$student->get_datum_narozeni()) ?>" required>

            <label for="telefon">Telefon</label>
            <input type="text" name="telefon" id="telefon"
                   value="<?= htmlspecialchars((string)$student->get_telefon()) ?>" required>

            <label for="email">E-mail</label>
            <input type="text" name="email" id="email"
                   value="<?= htmlspecialchars((string)$student->get_email()) ?>" required>

            <label for="datum_registrace">Datum registrace</label>
            <input type="date" name="datum_registrace" id="datum_registrace"
                   value="<?= htmlspecialchars((string)$student->get_datum_registrace()) ?>" required>

            <button type="submit">Uložit změny</button>
        </form>
    <?php } ?>

    <p class="back-link"><a href="../forms_display/form-studenti.php">&laquo; Zpět na seznam</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
