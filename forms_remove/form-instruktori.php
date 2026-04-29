<?php
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

$db = new InstruktoriDatabase();

$id = null;
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_POST['id'];
} elseif (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Smazání instruktora</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>

<body>
    <header>
        <h1>Smazání instruktora</h1>
    </header>
    <main class="flex-main">
        <?php
        if ($id === null) {
            echo "<p>Neplatné ID instruktora.</p>";
        } else {
            $instruktor = $db->getById($id);

            if ($instruktor === null) {
                echo "<p>Instruktor s ID " . htmlspecialchars((string)$id) . " nenalezen.</p>";
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrdit'])) {
                $smazany = $instruktor;
                if ($db->delete($id)) {
                    echo "<h2>Instruktor byl úspěšně smazán.</h2>";
                    $smazany->vypis();
                } else {
                    echo "<h2>Chyba při mazání instruktora.</h2>";
                }
            } else {
                echo "<p>Opravdu chcete smazat tohoto instruktora?</p>";
                $instruktor->vypis();
        ?>
                <form method="post" class="styled-panel">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$id) ?>">
                    <button type="submit" name="potvrdit" value="1">Smazat instruktora</button>
                </form>
        <?php
            }
        }
        ?>
        <p><a href="../forms_display/form-instruktori.php">Zpět na seznam</a></p>
    </main>
</body>

</html>