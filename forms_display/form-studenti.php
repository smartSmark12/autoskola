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
        <h1>Studenti načtení</h1>
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
        <div class="article-vypis">
            
        </div>
    </main>
</body>

<script>
    function kontrola() {
        ; /* very safe haha fixme */
    }
</script>

</html>