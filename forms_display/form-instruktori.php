<?php
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

$db = new InstruktoriDatabase();

$sort = $_GET['sort'] ?? 'prijmeni ASC';
$instruktori = $db->getAll($sort);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Výpis instruktorů</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <h1>Seznam instruktorů</h1>
    <main class="flex-main">
        <p>
            Řadit podle:
            <a href="?sort=prijmeni+ASC">Příjmení &uarr;</a> |
            <a href="?sort=prijmeni+DESC">Příjmení &darr;</a> |
            <a href="?sort=jmeno+ASC">Jméno &uarr;</a> |
            <a href="?sort=id+ASC">ID &uarr;</a>
        </p>
        <div class="panel-vypis">
            <?php foreach ($instruktori as $i): ?>
                <?php $i->vypisSOdkazy(); ?>
            <?php endforeach; ?>
        </div>
        <p>
            <a href="../forms/form-instruktori.php">Vložit nového instruktora</a> |
            <a href="../index.php">Zpět na hlavní menu</a>
        </p>
    </main>
</body>
</html>
