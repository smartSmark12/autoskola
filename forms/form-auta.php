<?php
require_once __DIR__ . "/../clases/Auta.php";

$zprava = "";
$auto = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auto = new Auta();

    if ($auto->nastavHodnoty($_POST)) {
        $zprava = "Auto bylo úspěšně uloženo.";
    } else {
        $zprava = "Chyba: zkontroluj zadaná data.";
        $auto = null;
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Evidence aut</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef1f4;
            padding: 40px;
        }
        .box {
            max-width: 450px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .msg {
            margin-bottom: 15px;
            font-weight: bold;
        }
        .ok { color: green; }
        .err { color: red; }
    </style>
</head>
<body>

<div class="box">
    <h2>Přidání auta</h2>

    <?php if ($zprava): ?>
        <div class="msg <?= $auto ? 'ok' : 'err' ?>">
            <?= htmlspecialchars($zprava) ?>
        </div>
    <?php endif; ?>

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

        <button type="submit">Uložit auto</button>
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