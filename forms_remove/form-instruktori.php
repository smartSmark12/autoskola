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

$pageTitle   = 'Smazání instruktora';
$pageHeading = 'Smazání instruktora';
$pageActive  = 'odebrani';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<?php
if ($id === null) {
    echo "<div class='msg-err'>Neplatné ID instruktora.</div>";
} else {
    $instruktor = $db->getById($id);
    if ($instruktor === null) {
        echo "<div class='msg-err'>Instruktor s ID " . htmlspecialchars((string)$id) . " nenalezen.</div>";
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrdit'])) {
        $smazany = $instruktor;
        if ($db->delete($id)) {
            echo "<div class='msg-ok'>Instruktor byl úspěšně smazán.</div>";
            $smazany->vypis();
        } else {
            echo "<div class='msg-err'>Chyba při mazání instruktora.</div>";
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

<p class="back-link"><a href="../forms_display/form-instruktori.php">&laquo; Zpět na seznam</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
