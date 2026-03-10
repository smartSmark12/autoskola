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
        <form method="POST" class="display-form">
            <label for="sort"><strong>Řazení:</strong></label>
            <select name="sort" id="sort">
                <option value="prijmeni">Příjmení</option>
                <option value="jmeno">Jméno</option>
                <option value="datum_narozeni">Datum narození</option>
                <option value="datum_registrace">Datum registrace</option>
            </select>

            <button type="submit">Načíst</button>
        </form>

        <div class="panel-vypis">
            <?php

            require_once "../framework/studenti_db.php";
            require_once "../clases/Studenti.php";

            $db = new StudentiDatabase();

            if (isset($_POST["sort"]))  {

                $students = $db->readStudents($_POST["sort"]);

                foreach($students as $student){
                    echo $student->vypisArticle();
                }
            }

            ?>
        </div>
    </main>
</body>

<script>
    function kontrola() {
        ; /* very safe haha fixme */
    }
</script>

</html>