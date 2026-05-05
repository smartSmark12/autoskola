<?php
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();
$sort = $_GET['sort'] ?? 'zacatek DESC';
$jizdy = $db->getAll($sort);

$pageTitle   = 'Administrace jízd';
$pageHeading = 'Administrace jízd';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<form class="display-form" action="" method="get">
    <h3>Řadit:</h3>
    <a href="?sort=zacatek+DESC">Od nejnovějších</a>
    <a href="?sort=zacatek+ASC">Od nejstarších</a>
    <a href="?sort=student_prijmeni+ASC">Dle studenta</a>
    <a href="?sort=instruktor_prijmeni+ASC">Dle instruktora</a>
    <a href="?sort=znacka+ASC">Dle značky auta</a>
    <a href="?sort=stav+ASC">Dle stavu</a>
</form>

<div class="panel-vypis">
    <?php foreach ($jizdy as $j): ?>
        <?php $j->vypisSOdkazy(); ?>
    <?php endforeach; ?>
</div>

<p class="back-link">
    <a href="../forms/form-jizdy.php">+ Vložit novou jízdu</a>
    <a href="../index.php">&laquo; Zpět na hlavní menu</a>
</p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
