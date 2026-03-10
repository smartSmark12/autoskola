<!-- VK -->
 
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studenti form</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <header>
        <h1>Studenti vložení</h1>
    </header>
    <main class="styled-panel-container">
        <?php

        require_once "../framework/studenti_db.php";
        require_once "../clases/Studenti.php";

        $db = new StudentiDatabase();

        if (isset($_POST["jmeno"])) {
            $student = new Studenti();
            
            $student->nastavHodnoty($_POST["jmeno"],$_POST["prijmeni"],$_POST["datum_narozeni"],$_POST["telefon"],$_POST["email"],$_POST["datum_registrace"]);

            $student_id = $db->insertStudent($student);

            if($student_id > 0){echo "<h2>Data byla vložena</h2>\n"; }
            else {echo "<h2>Data nebyla vložena</h2>\n";}
        }

        ?>
        <form method="post", onsubmit=kontrola class="styled-panel">
            <label for="jmeno">Jméno</label>
            <input type="text" name="jmeno"> <!--  placeholder="jméno" -->
            <label for="prijmeni">Příjmení</label>
            <input type="text" name="prijmeni"> <!--  placeholder="příjmení" -->
            <label for="datum_narozeni">Datum narození</label>
            <input type="date" name="datum_narozeni"> <!--  placeholder="datum narození" -->
            <label for="telefon">Telefon</label>
            <input type="text" name="telefon"> <!--  placeholder="telefon" -->
            <label for="email">E-mail</label>
            <input type="text" name="email"> <!-- placeholder="e-mail" -->
            <label for="datum_registrace">Datum registrace</label>
            <input type="date" name="datum_registrace"> <!--  placeholder="datum registrace" -->
            <button type="submit">Vložit</button>
        </form>
    </main>
</body>

<script>
    function kontrola() {
        ; /* very safe haha fixme */
    }
</script>

</html>