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
        // Load database layer and model class
        require_once "../framework/instruktori_db.php";
        require_once "../clases/Instruktori.php";

        $db = new InstruktoriDatabase();

        // Process form submission
        if (isset($_POST["jmeno"])) {
            $instruktor = new Instruktori();

            // Read POST data with fallback to empty string
            $jmeno = isset($_POST['jmeno']) ? $_POST['jmeno'] : '';
            $prijmeni = isset($_POST['prijmeni']) ? $_POST['prijmeni'] : '';
            $telefon = isset($_POST['telefon']) ? $_POST['telefon'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';

            try {
                // Validate and set values, then insert into database
                $instruktor->nastavHodnoty(null, $jmeno, $prijmeni, $telefon, $email, true);
                $instruktor_id = $db->insertInstruktor($instruktor);

                if($instruktor_id !== false && $instruktor_id !== 0){
                    echo "<h2>Data byla vložena</h2>\n";
                } else {
                    echo "<h2>Data nebyla vložena</h2>\n";
                }
            } catch (Exception $e) {
                echo '<h2>Chyba: ' . htmlspecialchars($e->getMessage()) . '</h2>';
            }
        }
        ?>
        <!-- Instructor insert form with client-side validation -->
        <form method="post" onsubmit="return kontrola();" class="styled-panel">
            <label for="jmeno">Jméno</label>
            <input type="text" name="jmeno" required>
            <label for="prijmeni">Příjmení</label>
            <input type="text" name="prijmeni" required>
            <label for="telefon">Telefon</label>
            <input type="text" name="telefon">
            <label for="email">E-mail</label>
            <input type="text" name="email">
            <button type="submit">Vložit instruktora</button>
        </form>
    </main>
</body>

<script>
    // Client-side validation: ensure name and surname are filled
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

</html>
