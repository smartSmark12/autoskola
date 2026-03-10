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
        <div class="panel-vypis">
            <?php

            require_once "../framework/studenti_db.php";
            require_once "../clases/Studenti.php";

            $db = new StudentiDatabase();

            $students = $db->readStudents();

            foreach($students as $student){
                echo $student->vypisArticle();
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