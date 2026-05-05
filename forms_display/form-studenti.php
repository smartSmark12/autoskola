<?php
require_once __DIR__ . "/../framework/studenti_db.php";
require_once __DIR__ . "/../clases/Studenti.php";

$db = new StudentiDatabase();
$students = null;

if (isset($_POST["sort"])) {
    $students = $db->readStudents($_POST["sort"]);
}

$pageTitle   = 'Výpis studentů';
$pageHeading = 'Seznam studentů';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<form method="POST" class="display-form">
    <h3>Řazení:</h3>
    <select name="sort" id="sort">
        <option value="prijmeni">Příjmení</option>
        <option value="jmeno">Jméno</option>
        <option value="datum_narozeni">Datum narození</option>
        <option value="datum_registrace">Datum registrace</option>
    </select>
    <button type="submit">Načíst</button>
</form>

<div class="panel-vypis">
    <?php if ($students !== null): ?>
        <?php foreach ($students as $student) {
            echo $student->vypisArticle();
        } ?>
    <?php else: ?>
        <p class="empty-hint">Vyberte řazení a klikněte na <strong>Načíst</strong>.</p>
    <?php endif; ?>
</div>

<p class="back-link">
    <a href="../forms/form-studenti.php">+ Vložit nového studenta</a>
    <a href="../index.php">&laquo; Zpět na hlavní menu</a>
</p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
