<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruktoři form</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <header>
        <h1>Instruktoři vložení</h1>
    </header>
    <main class="styled-panel-container">
        <?php
        require_once "../framework/instruktori_db.php";
        require_once "../clases/Instruktori.php";

        $db = new InstruktoriDatabase();

        // Zpracování odeslaného formuláře — nejdřív validace v modelu, pak insert.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $instruktor = new Instruktori();

            $jmeno    = $_POST['jmeno']    ?? '';
            $prijmeni = $_POST['prijmeni'] ?? '';
            $telefon  = $_POST['telefon']  ?? '';
            $email    = $_POST['email']    ?? '';

            if ($instruktor->nastavHodnoty(null, $jmeno, $prijmeni, $telefon, $email, true) === false) {
                echo "<h2>Chyba: zadané hodnoty nejsou platné</h2>\n";
            } else {
                $instruktor_id = $db->insertInstruktor($instruktor);

                if ($instruktor_id !== false && $instruktor_id !== 0) {
                    echo "<h2>Data byla vložena</h2>\n";
                    $vlozeny = $db->getById((int)$instruktor_id);
                    if ($vlozeny) { $vlozeny->vypis(); }
                } else {
                    echo "<h2>Data nebyla vložena</h2>\n";
                }
            }
        }
        ?>
        <form method="post" onsubmit="return kontrola();" class="styled-panel">
            <label for="jmeno">Jméno</label>
            <input type="text" name="jmeno" maxlength="50" required>
            <label for="prijmeni">Příjmení</label>
            <input type="text" name="prijmeni" maxlength="50" required>
            <label for="telefon">Telefon</label>
            <input type="text" name="telefon" maxlength="20" placeholder="+420 123 456 789">
            <label for="email">E-mail</label>
            <input type="text" name="email" maxlength="100">
            <button type="submit">Vložit instruktora</button>
        </form>
        <p><a href="../forms_display/form-instruktori.php">Zpět na výpis</a></p>
    </main>

<script>
    function kontrola() {
        var jmeno = document.querySelector('input[name="jmeno"]').value.trim();
        var prijmeni = document.querySelector('input[name="prijmeni"]').value.trim();
        if (!jmeno || !prijmeni) {
            alert('Vyplňte jméno i příjmení.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
