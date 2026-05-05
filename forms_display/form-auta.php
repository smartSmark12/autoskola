<?php
require_once __DIR__ . "/../framework/auta_db.php";
require_once __DIR__ . "/../clases/auta.php";

$db = new AutaDatabase();
$order = $_GET['order'] ?? "znacka ASC";
$auta = $db->getAll($order);

$pageTitle   = 'Administrace aut';
$pageHeading = 'Administrace aut';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<form action="" method="get" class="display-form">
    <h3>Řazení:</h3>
    <a href="?order=znacka ASC">Značka A-Z</a>
    <a href="?order=znacka DESC">Značka Z-A</a>
    <a href="?order=model ASC">Model</a>
    <a href="?order=poznavaci_znacka ASC">SPZ</a>
    <a href="?order=id DESC">Nejnovější</a>
    <a href="?order=id ASC">Nejstarší</a>
</form>

<div class="panel-vypis">
    <?php foreach ($auta as $auto) { $auto->vypisAdmin(); } ?>
</div>

<p class="back-link"><a href="../forms/form-auta.php">+ Vložit auto</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
