<?php
// Load database layer and model class
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

// Fetch all instructors sorted by surname
$db = new InstruktoriDatabase();
$instruktori = $db->getAll();
?>
<!DOCTYPE html>
<html>
<head><title>Výpis instruktorů</title></head>
<link rel="stylesheet" href="../bordel/style.css">
<body>
    <h1>Seznam instruktorů</h1>
    <main class="flex-main">
        <div class="panel-vypis">
            <!-- Loop through all instructors and display each one -->
            <?php foreach ($instruktori as $i): ?>
                <article class="display-card"> <!-- style="border: 1px solid gray; margin: 10px; padding: 10px;" -->
                    <?php $i->vypis(); ?>
                    <a href="../forms_remove/form-instruktori.php?id=<?php echo $i->getId(); ?>">Smazat</a>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
