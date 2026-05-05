<?php
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

$db = new InstruktoriDatabase();
$sort = $_GET['sort'] ?? 'prijmeni ASC';
$instruktori = $db->getAll($sort);

$pageTitle   = 'Výpis instruktorů';
$pageHeading = 'Seznam instruktorů';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<form class="display-form" action="" method="get">
    <h3>Řadit podle:</h3>
    <a href="?sort=prijmeni+ASC">Příjmení &uarr;</a>
    <a href="?sort=prijmeni+DESC">Příjmení &darr;</a>
    <a href="?sort=jmeno+ASC">Jméno &uarr;</a>
    <a href="?sort=id+ASC">ID &uarr;</a>
</form>

<div class="panel-vypis">
    <?php foreach ($instruktori as $i): ?>
        <?php $i->vypisSOdkazy(); ?>
    <?php endforeach; ?>
</div>

<p class="back-link">
    <a href="../forms/form-instruktori.php">+ Vložit nového instruktora</a>
    <a href="../index.php">&laquo; Zpět na hlavní menu</a>
</p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
