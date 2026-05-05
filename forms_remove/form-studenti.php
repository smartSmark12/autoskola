<?php
require_once __DIR__ . "/../framework/studenti_db.php";

$pageTitle   = 'Smazání studenta';
$pageHeading = 'Smazání studenta';
$pageActive  = 'odebrani';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $db = new StudentiDatabase();
    $result = $db->delete((int)$_GET['id']);
    if ($result) {
        echo "<div class='msg-ok'>Student byl úspěšně smazán.</div>";
    } else {
        echo "<div class='msg-err'>Chyba při mazání studenta.</div>";
    }
} else {
    echo "<div class='msg-err'>Neplatné ID studenta.</div>";
}
?>

<p class="back-link"><a href="../forms_display/form-studenti.php">&laquo; Zpět na seznam</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
