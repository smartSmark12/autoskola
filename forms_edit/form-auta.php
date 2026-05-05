<?php
require_once __DIR__ . "/../framework/auta_db.php";
require_once __DIR__ . "/../clases/auta.php";

$db = new AutaDatabase();
$id = $_GET["id"] ?? $_POST["id"] ?? null;
$zprava = '';
$msgClass = '';
$auto = null;

if ($id === null) {
    $zprava = "ID nebylo zadáno";
    $msgClass = 'msg-err';
} else {
    $auto = $db->getById($id);
    if (!$auto) {
        $zprava = "Auto nebylo nalezeno";
        $msgClass = 'msg-err';
    } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $auto->nastavHodnoty([
                "znacka" => $_POST["znacka"],
                "model" => $_POST["model"],
                "poznavaci_znacka" => $_POST["poznavaci_znacka"],
                "aktivni" => $_POST["aktivni"]
            ]);

            if ($db->updateById($id, $auto)) {
                $zprava = "Auto bylo úspěšně upraveno.";
                $msgClass = 'msg-ok';
            } else {
                $zprava = "Chyba při ukládání.";
                $msgClass = 'msg-err';
            }
        } catch (Exception $e) {
            $zprava = "Chyba: " . $e->getMessage();
            $msgClass = 'msg-err';
        }
    }
}

$pageTitle   = 'Editace auta';
$pageHeading = 'Editace auta';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<?php if ($zprava): ?>
    <div class="<?= $msgClass ?>"><?= htmlspecialchars($zprava) ?></div>
<?php endif; ?>

<?php if ($auto): ?>
    <form method="post" class="styled-panel">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$auto->id) ?>">

        <label>Značka</label>
        <input type="text" name="znacka" value="<?= htmlspecialchars($auto->znacka) ?>" required>

        <label>Model</label>
        <input type="text" name="model" value="<?= htmlspecialchars($auto->model) ?>" required>

        <label>SPZ</label>
        <input type="text" name="poznavaci_znacka" value="<?= htmlspecialchars($auto->poznavaci_znacka) ?>" required>

        <label>Stav</label>
        <select name="aktivni">
            <option value="1" <?= $auto->aktivni == 1 ? 'selected' : '' ?>>Aktivní</option>
            <option value="0" <?= $auto->aktivni == 0 ? 'selected' : '' ?>>Neaktivní</option>
        </select>

        <button type="submit">Uložit změny</button>
    </form>
<?php endif; ?>

<p class="back-link"><a href="../forms_display/form-auta.php">&laquo; Zpět na výpis</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
