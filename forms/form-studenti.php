<?php
require_once __DIR__ . "/../framework/auth.php";
Auth::requireInstruktor("../");
$pageTitle   = 'Vložení studenta';
$pageHeading = 'Studenti vložení';
$pageActive  = 'vlozeni';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>
<?php

require_once "../framework/studenti_db.php";
require_once "../clases/Studenti.php";

$db = new StudentiDatabase();

if (isset($_POST["jmeno"])) {
    $student = new Studenti();

    $student->nastavHodnoty($_POST["jmeno"],$_POST["prijmeni"],$_POST["datum_narozeni"],$_POST["telefon"],$_POST["email"],$_POST["datum_registrace"]);

    $student_id = $db->insertStudent($student);

}

?>
<form method="post" class="styled-panel">
    <label for="jmeno">Jméno</label>
    <input type="text" name="jmeno" required>
    <label for="prijmeni">Příjmení</label>
    <input type="text" name="prijmeni" required>
    <label for="datum_narozeni">Datum narození</label>
    <input type="date" name="datum_narozeni" required>
    <label for="telefon">Telefon</label>
    <input type="text" name="telefon" required>
    <label for="email">E-mail</label>
    <input type="text" name="email" required>
    <label for="datum_registrace">Datum registrace</label>
    <input type="date" name="datum_registrace" required>
    <button type="submit">Vložit</button>
</form>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
