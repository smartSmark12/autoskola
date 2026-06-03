<?php
require_once __DIR__ . "/../framework/auth.php";
Auth::requireLogin("../");
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();
$sort = $_GET['sort'] ?? 'zacatek DESC';

$jeInstruktor = Auth::jeInstruktor();
$mojeId       = Auth::id();

if ($jeInstruktor) {
    // Instruktor vidí všechny jízdy, může řadit a filtrovat.
    $filters = [
        'id_studenta'    => $_GET['id_studenta']    ?? '',
        'id_instruktora' => $_GET['id_instruktora'] ?? '',
        'id_auta'        => $_GET['id_auta']        ?? '',
        'datum_od'       => $_GET['datum_od']       ?? '',
        'datum_do'       => $_GET['datum_do']       ?? '',
    ];
    $jizdy       = $db->getAll($sort, $filters);
    $studenti    = $db->getStudentiForSelect();
    $instruktori = $db->getInstruktoriForSelect();
    $auta        = $db->getAutaForSelect();
    $pageTitle   = 'Administrace jízd';
    $pageHeading = 'Administrace jízd';
} else {
    // Žák vidí pouze své naplánované jízdy.
    $jizdy       = $db->getForStudent($mojeId, $sort);
    $pageTitle   = 'Moje jízdy';
    $pageHeading = 'Moje naplánované jízdy';
}

$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';

// Pomocná funkce: zachová sort v odkazu, nebo ho přepíše.
function sortLink($newSort) {
    $q = $_GET;
    $q['sort'] = $newSort;
    return '?' . http_build_query($q);
}
?>

<?php if ($jeInstruktor): ?>
<form class="display-form" action="" method="get">
    <h3>Řadit:</h3>
    <a href="<?= htmlspecialchars(sortLink('zacatek DESC')) ?>">Od nejnovějších</a>
    <a href="<?= htmlspecialchars(sortLink('zacatek ASC')) ?>">Od nejstarších</a>
    <a href="<?= htmlspecialchars(sortLink('student_prijmeni ASC')) ?>">Dle studenta</a>
    <a href="<?= htmlspecialchars(sortLink('instruktor_prijmeni ASC')) ?>">Dle instruktora</a>
    <a href="<?= htmlspecialchars(sortLink('znacka ASC')) ?>">Dle značky auta</a>
    <a href="<?= htmlspecialchars(sortLink('stav ASC')) ?>">Dle stavu</a>
</form>

<form class="display-form" action="" method="get">
    <h3>Filtr:</h3>
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
    <select name="id_studenta">
        <option value="">— student —</option>
        <?php foreach ($studenti as $s): ?>
            <option value="<?= htmlspecialchars((string)$s['id']) ?>"
                <?= ((string)($filters['id_studenta']) === (string)$s['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="id_instruktora">
        <option value="">— instruktor —</option>
        <?php foreach ($instruktori as $i): ?>
            <option value="<?= htmlspecialchars((string)$i['id']) ?>"
                <?= ((string)($filters['id_instruktora']) === (string)$i['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($i['prijmeni'] . ' ' . $i['jmeno']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="id_auta">
        <option value="">— auto —</option>
        <?php foreach ($auta as $a): ?>
            <option value="<?= htmlspecialchars((string)$a['id']) ?>"
                <?= ((string)($filters['id_auta']) === (string)$a['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($a['poznavaci_znacka'] . ' — ' . $a['znacka'] . ' ' . $a['model']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>od <input type="date" name="datum_od" value="<?= htmlspecialchars($filters['datum_od']) ?>"></label>
    <label>do <input type="date" name="datum_do" value="<?= htmlspecialchars($filters['datum_do']) ?>"></label>
    <button type="submit">Filtrovat</button>
    <a href="?">Zrušit filtr</a>
</form>
<?php endif; ?>

<div class="panel-vypis">
    <?php if (empty($jizdy)): ?>
        <p class="empty-hint">Žádné jízdy k zobrazení.</p>
    <?php else: ?>
        <?php foreach ($jizdy as $j): ?>
            <?php
            if ($jeInstruktor) {
                // Editovat/mazat smí instruktor jen vlastní jízdy.
                $j->vypisSOdkazy((int)$j->getIdInstruktora() === (int)$mojeId);
            } else {
                // Žák má pouze čtení.
                $j->vypis();
            }
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<p class="back-link">
    <?php if ($jeInstruktor): ?>
        <a href="../forms/form-jizdy.php">+ Vložit novou jízdu</a>
    <?php endif; ?>
    <a href="../index.php">&laquo; Zpět na hlavní menu</a>
</p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
