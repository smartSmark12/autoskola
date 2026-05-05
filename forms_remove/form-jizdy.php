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

$pageTitle   = 'Smazání jízdy';
$pageHeading = 'Smazání jízdy';
$pageActive  = 'odebrani';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<?php
if ($id === null) {
    echo "<div class='msg-err'>Neplatné ID jízdy.</div>";
} else {
    $jizda = $db->getById($id);
    if ($jizda === null) {
        echo "<div class='msg-err'>Jízda s ID " . htmlspecialchars((string)$id) . " nenalezena.</div>";
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrdit'])) {
        $smazana = $jizda;
        if ($db->delete($id)) {
            echo "<div class='msg-ok'>Jízda byla úspěšně smazána.</div>";
            $smazana->vypis();
        } else {
            echo "<div class='msg-err'>Chyba při mazání jízdy.</div>";
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

<p class="back-link"><a href="../forms_display/form-jizdy.php">&laquo; Zpět na seznam</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
