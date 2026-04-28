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

$zprava = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        $auto->nastavHodnoty([
            "znacka" => $_POST["znacka"],
            "model" => $_POST["model"],
            "poznavaci_znacka" => $_POST["poznavaci_znacka"],
            "aktivni" => $_POST["aktivni"]
        ]);

        if ($db->updateById($id, $auto)) {
            $zprava = "Auto bylo úspěšně upraveno.";
        } else {
            $zprava = "Chyba při ukládání.";
        }

    } catch (Exception $e) {
        $zprava = "Chyba: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Editace auta</title>
</head>

<body>

<h1>Editace auta</h1>

<?php
if ($zprava) {
    echo "<p>$zprava</p>";
}
?>

<form method="post">

<input type="hidden" name="id" value="<?php echo $auto->id; ?>">

<label>Značka:</label>
<input type="text" name="znacka" value="<?php echo htmlspecialchars($auto->znacka); ?>" required>
<br><br>

<label>Model:</label>
<input type="text" name="model" value="<?php echo htmlspecialchars($auto->model); ?>" required>
<br><br>

<label>SPZ:</label>
<input type="text" name="poznavaci_znacka" value="<?php echo htmlspecialchars($auto->poznavaci_znacka); ?>" required>
<br><br>

<label>Stav:</label>
<select name="aktivni">
    <option value="1" <?php if ($auto->aktivni == 1) echo "selected"; ?>>Aktivní</option>
    <option value="0" <?php if ($auto->aktivni == 0) echo "selected"; ?>>Neaktivní</option>
</select>

<br><br>

<button type="submit">Uložit změny</button>

</form>

<br>

<a href="../forms_display/form-auta.php">Zpět na administraci</a>

</body>
</html>