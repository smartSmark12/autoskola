<?php
require_once __DIR__ . "/../framework/auta_db.php";
require_once __DIR__ . "/../clases/auta.php";

$db = new AutaDatabase();
$id = $_GET["id"] ?? $_POST["id"] ?? null;
$zprava = '';
$smazano = false;

if ($id === null) {
    $zprava = "<div class='msg-err'>ID nebylo zadáno.</div>";
} else {
    $auto = $db->getById($id);
    if (!$auto) {
        $zprava = "<div class='msg-err'>Auto nebylo nalezeno.</div>";
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($db->deleteById($id)) {
            $zprava = "<div class='msg-ok'>Auto bylo smazáno.</div>";
            $smazano = true;
        } else {
            $zprava = "<div class='msg-err'>Chyba při mazání.</div>";
        }
    }
}

$pageTitle   = 'Smazání auta';
$pageHeading = 'Smazání auta';
$pageActive  = 'odebrani';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<?= $zprava ?>

<?php if (!$smazano && isset($auto) && $auto): ?>
    <p>Opravdu chcete smazat toto auto?</p>
    <?php $auto->vypis(); ?>
    <form method="post" class="styled-panel">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$auto->id) ?>">
        <button type="submit">Smazat auto</button>
    </form>
<?php endif; ?>

<p class="back-link"><a href="../forms_display/form-auta.php">&laquo; Zpět na výpis</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
