<?php
require_once "../framework/auta_db.php";
require_once "../clases/auta.php";

$db = new AutaDatabase();

$order = $_GET['order'] ?? "znacka ASC";

$auta = $db->getAll($order);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Administrace aut</title>
<link rel="stylesheet" href="../bordel/style.css">
</head>

<body>

<h1>Administrace aut</h1>

<h3>Řazení</h3>

<a href="?order=znacka ASC">Značka A-Z</a> |
<a href="?order=znacka DESC">Značka Z-A</a> |
<a href="?order=model ASC">Model</a> |
<a href="?order=poznavaci_znacka ASC">SPZ</a> |
<a href="?order=id DESC">Nejnovější</a> |
<a href="?order=id ASC">Nejstarší</a>

<hr>

<?php

foreach ($auta as $auto) {
    $auto->vypisAdmin();
}

?>

</body>
</html>