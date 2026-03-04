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

            $ok = $instruktor->nastavHodnoty(null, $_POST['jmeno'], $_POST['prijmeni'], $_POST['telefon'], $_POST['email'], true);

            if ($ok) {
                $instruktor_id = $db->insertInstruktor($instruktor);
                if($instruktor_id){
                    echo "<h2>Data byla vložena</h2>\n";
                    $instruktor->vypis();
                } else {
                    echo "<h2>Data nebyla vložena do DB</h2>\n";
                }
            } else {
                echo "<h2>Chyba: Nevalidní data</h2>\n";
            }
        }
        ?>
        <form method="post" onsubmit="return kontrola();">
            <input type="text" name="jmeno" placeholder="jméno">
            <input type="text" name="prijmeni" placeholder="příjmení">
            <input type="text" name="telefon" placeholder="telefon">
            <input type="text" name="email" placeholder="e-mail">
            <button type="submit">Uložit</button>
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