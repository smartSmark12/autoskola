<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulář aut</title>
</head>
<body>
    <header>
        <h1>Přidání auta</h1>
    </header>
    <main>
        <?php
        require_once "../framework/auta_db.php";
        require_once "../clases/Auta.php";

        
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

        <form method="post" onsubmit="return kontrola();">
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