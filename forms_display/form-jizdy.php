<?php
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();

$sort = $_GET['sort'] ?? 'zacatek DESC';
$jizdy = $db->getAll($sort);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Administrace jízd</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <h1>Administrace jízd</h1>
    <p>
        Řadit:
        <a href="?sort=zacatek+DESC">Od nejnovějších</a> |
        <a href="?sort=zacatek+ASC">Od nejstarších</a> |
        <a href="?sort=student_prijmeni+ASC">Dle studenta</a> |
        <a href="?sort=instruktor_prijmeni+ASC">Dle instruktora</a> |
        <a href="?sort=znacka+ASC">Dle značky auta</a> |
        <a href="?sort=stav+ASC">Dle stavu</a>
    </p>
    <main class="flex-main">
        <div class="panel-vypis">
            <?php foreach ($jizdy as $j): ?>
                <?php $j->vypisSOdkazy(); ?>
            <?php endforeach; ?>
        </div>
    </main>
    <p>
        <a href="../forms/form-jizdy.php">Vložit novou jízdu</a> |
        <a href="../index.php">Zpět na hlavní menu</a>
    </p>
</body>
</html>
