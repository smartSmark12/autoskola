<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studenti form</title>
</head>
<body>
    <header>
        <h1>Studenti</h1>
    </header>
    <main>
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
        <form method="post", onsubmit=kontrola>
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
        ;
    }
</script>

</html>