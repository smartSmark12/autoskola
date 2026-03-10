<?php

require_once "../framework/auta_db.php";
require_once "../clases/Auta.php";

$db = new AutaDatabase();

$id = $_GET["id"] ?? $_POST["id"] ?? null;

if ($id === null) {
    die("ID nebylo zadáno");
}

$auto = $db->getById($id);

if (!$auto) {
    die("Auto nebylo nalezeno");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($db->deleteById($id)) {
        echo "<h2>Auto bylo smazáno.</h2>";
        echo "<a href='../forms_display/auta-admin.php'>Zpět na administraci</a>";
        exit;
    } else {
        echo "<h2>Chyba při mazání.</h2>";
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Smazání auta</title>
</head>

<body>

<h1>Smazání auta</h1>

<p>Opravdu chcete smazat toto auto?</p>

<?php
$auto->vypis();
?>

<form method="post">
<input type="hidden" name="id" value="<?php echo $auto->id; ?>">
<button type="submit">Smazat auto</button>
</form>

<br>

<a href="../forms_display/auta-admin.php">Zpět</a>

</body>
</html>