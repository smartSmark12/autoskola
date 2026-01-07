<?php
require_once __DIR__ . "/../clases/Auta.php";
require_once __DIR__ . "/../clases/AutaDB.php";

$auto = null;

if (isset($_POST["ulozit"])) {

    $auto = new Auta();

    if ($auto->nastavHodnoty($_POST)) {

        $db = new AutaDB();
        $id = $db->vlozAuto($auto);

        if ($id > 0) {
            echo "<h2 style='color:green'>Auto bylo vloženo (ID: $id)</h2>";
        } else {
            echo "<h2 style='color:red'>Chyba při ukládání do databáze</h2>";
        }

    } else {
        echo "<h2 style='color:red'>Chybná data ve formuláři</h2>";
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Evidence aut</title>
</head>
<body>

<div class="box">

<h1>Auta – vložení do databáze</h1>

<form method="post">
    <label>Značka</label>
    <input type="text" name="znacka" required>

    <label>Model</label>
    <input type="text" name="model" required>

    <label>SPZ</label>
    <input type="text" name="poznavaci_znacka" required>

    <label>Aktivní</label>
    <select name="aktivni">
        <option value="1">Ano</option>
        <option value="0">Ne</option>
    </select>

    <br><br>
    <button type="submit" name="ulozit">Uložit</button>
</form>

<?php
if ($auto) {
    echo "<hr>";
    $auto->vypis();
}
?>

</div>

</body>
</html>