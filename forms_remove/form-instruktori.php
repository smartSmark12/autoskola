<?php
require_once "../framework/instruktori_db.php";

// Validate ID from GET parameter and delete the instructor
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $db = new InstruktoriDatabase();
    $result = $db->delete((int)$_GET['id']);

    if ($result) {
        echo "<p>Instruktor byl úspěšně smazán.</p>";
    } else {
        echo "<p>Chyba při mazání instruktora.</p>";
    }
} else {
    echo "<p>Neplatné ID instruktora.</p>";
}
?>
<a href="../forms_display/form-instruktori.php">Zpět na seznam</a>
