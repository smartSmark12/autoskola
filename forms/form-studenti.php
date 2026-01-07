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

        include_once "../framework/studenti_db.php";
        include_once "../classes/Studenti.php";

        $db = new StudentiDatabase();

        if (isset($_POST["submit"])) {
            $student = new Student();
            
            $tempid = 0;
            $student->nastavHodnoty($tempid, $_POST["jmeno"],$_POST["prijmeni"],$_POST["datum_narozeni"],$_POST["telefon"],$_POST["email"],$_POST["datum_registrace"]);

            $student_id = $db->insertStudent($student);
        }

        ?>
        <form method="post", onsubmit=kontrola>
            <input type="text" placeholder="jméno">
            <input type="text" placeholder="příjmení">
            <input type="date" placeholder="datum narození">
            <input type="text" placeholder="telefon">
            <input type="text" placeholder="e-mail">
            <input type="date" placeholder="datum registrace">
            <input type="button" value="submit">
        </form>
    </main>
</body>

<script>
    function kontrola() {
        ;
    }
</script>

</html>