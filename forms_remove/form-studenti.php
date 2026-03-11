<!-- VK od RB -->

<?php
require_once "../framework/studenti_db.php";

// Validate ID from GET parameter and delete the instructor
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $db = new StudentiDatabase();
    $result = $db->delete((int)$_GET['id']);

    if ($result) {
        echo "<p>Student byl úspěšně smazán.</p>";
    } else {
        echo "<p>Chyba při mazání studenta.</p>";
    }
} else {
    echo "<p>Neplatné ID studenta.</p>";
}
?>
<a href="../forms_display/form-studenti.php">Zpět na seznam</a>