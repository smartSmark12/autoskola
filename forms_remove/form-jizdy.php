<?php
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();

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
    <title>Smazání jízdy</title>
    <link rel="stylesheet" href="../bordel/style.css">
</head>
<body>
    <header><h1>Smazání jízdy</h1></header>
    <main class="styled-panel-container">
    <?php
    if ($id === null) {
        echo "<p>Neplatné ID jízdy.</p>";
    } else {
        $jizda = $db->getById($id);

        if ($jizda === null) {
            echo "<p>Jízda s ID " . htmlspecialchars((string)$id) . " nenalezena.</p>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrdit'])) {
            $smazana = $jizda;
            if ($db->delete($id)) {
                echo "<h2>Jízda byla úspěšně smazána.</h2>";
                $smazana->vypis();
            } else {
                echo "<h2>Chyba při mazání jízdy.</h2>";
            }
        } else {
            echo "<p>Opravdu chcete smazat tuto jízdu?</p>";
            $jizda->vypis();
            ?>
            <form method="post" class="styled-panel">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string)$id) ?>">
                <button type="submit" name="potvrdit" value="1">Smazat jízdu</button>
            </form>
            <?php
        }
    }
    ?>
    <p><a href="../forms_display/form-jizdy.php">Zpět na seznam</a></p>
    </main>
</body>
</html>
