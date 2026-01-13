<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruktoři form</title>
</head>
<body>
    <header>
        <h1>Instruktoři</h1>
    </header>
    <main>
        <?php

    require_once "../framework/instruktori_db.php";
    require_once "../clases/Instruktori.php";

        $db = new InstruktoriDatabase();

        if (isset($_POST["jmeno"])) {
            $instruktor = new Instruktori();

            $jmeno = isset($_POST['jmeno']) ? $_POST['jmeno'] : '';
            $prijmeni = isset($_POST['prijmeni']) ? $_POST['prijmeni'] : '';
            $telefon = isset($_POST['telefon']) ? $_POST['telefon'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';

            try {
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
        <form method="post" onsubmit="return kontrola();">
            <input type="text" name="jmeno" placeholder="jméno">
            <input type="text" name="prijmeni" placeholder="příjmení">
            <input type="date" name="datum_narozeni" placeholder="datum narození">
            <input type="text" name="telefon" placeholder="telefon">
            <input type="text" name="email" placeholder="e-mail">
            <input type="date" name="datum_registrace" placeholder="datum registrace">
            <button type="submit">:3333</button>
        </form>
    </main>
</body>

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

</html>