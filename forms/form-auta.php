<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulář aut</title>
    <style>
.auto-karta {
    border: 1px solid #ccc;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;
    background: #f9f9f9;
    box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
}
.auto-karta h2 {
    margin-top: 0;
    color: #2c3e50;
}
.auto-karta ul {
    list-style: none;
    padding: 0;
}
.auto-karta li {
    padding: 3px 0;
}
</style>
<link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <header>
        <h1>Přidání auta</h1>
    </header>
    <main class="styled-panel-container">
        <?php
        require_once "../framework/auta_db.php";
        require_once "../clases/auta.php";

        
        $zprava = "";
        $auto = null;

        $db = new AutaDatabase();
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $auto = new Auta();

            $znacka = $_POST['znacka'] ?? '';
            $model = $_POST['model'] ?? '';
            $poznavaci_znacka = $_POST['poznavaci_znacka'] ?? '';
            $aktivni = $_POST['aktivni'] ?? 1;

            try {
                $auto->nastavHodnoty([
                    "znacka" => $znacka,
                    "model" => $model,
                    "poznavaci_znacka" => $poznavaci_znacka,
                    "aktivni" => $aktivni
                ]);

                $auto_id = $db->insertAuto($auto);

                if ($auto_id !== false) {
                    $auto->id = $auto_id; 
                    echo "<h2>Auto bylo úspěšně vloženo (ID: $auto_id)</h2>";
                    $auto->vypis();
                } else {
                    echo "<h2>Chyba: Auto se nepodařilo uložit.</h2>";
                }
            } catch (Exception $e) {
                echo '<h2>Chyba: ' . htmlspecialchars($e->getMessage()) . '</h2>';
                $zprava = "Chyba: " . $e->getMessage();
                $auto = null;
            }
        }
        ?>

        <form method="post" onsubmit="return kontrola();" class="styled-panel">
            <input type="text" name="znacka" placeholder="Značka" required>
            <input type="text" name="model" placeholder="Model" required>
            <input type="text" name="poznavaci_znacka" placeholder="SPZ" required>
            <select name="aktivni">
                <option value="1">Aktivní</option>
                <option value="0">Neaktivní</option>
            </select>
            <button type="submit">Uložit auto</button>
        </form>
    </main>

    <script>
    function kontrola() {
        var znacka = document.querySelector('input[name="znacka"]').value.trim();
        var model = document.querySelector('input[name="model"]').value.trim();
        var spz = document.querySelector('input[name="poznavaci_znacka"]').value.trim();
        if (!znacka || !model || !spz) {
            alert('Vyplňte všechny povinné údaje.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>