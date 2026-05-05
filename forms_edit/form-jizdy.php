<?php
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();

// id přijde z GET při prokliku z výpisu, z POST při uložení formuláře.
$id = null;
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_POST['id'];
} elseif (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $id = (int)$_GET['id'];
}

$message = '';
$jizda = ($id !== null) ? $db->getById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $jizda !== null) {
    $upravena = new Jizdy();
    $ok = $upravena->nastavHodnoty(
        $id,
        $_POST['id_studenta']    ?? '',
        $_POST['id_instruktora'] ?? '',
        $_POST['id_auta']        ?? '',
        $_POST['zacatek']        ?? '',
        $_POST['konec']          ?? '',
        $_POST['stav']           ?? 'p'
    );

    if ($ok === false) {
        $message = "<div class='msg-err'>Chyba: zadané hodnoty nejsou platné</div>";
    } else {
        if ($db->update($upravena)) {
            $message = "<div class='msg-ok'>Data byla upravena</div>";
            $jizda = $db->getById($id);
        } else {
            $message = "<div class='msg-err'>Data nebyla upravena</div>";
        }
    }
}

$studenti    = $db->getStudentiForSelect();
$instruktori = $db->getInstruktoriForSelect();
$auta        = $db->getAutaForSelect();

$pageTitle   = 'Editace jízdy';
$pageHeading = 'Editace jízdy';
$pageActive  = 'vypis';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

    <?php
    echo $message;

    if ($id === null) {
        echo "<div class='msg-err'>Neplatné ID jízdy.</div>";
    } elseif ($jizda === null) {
        echo "<div class='msg-err'>Jízda s ID " . htmlspecialchars((string)$id) . " nenalezena.</div>";
    } else {
        // datetime z DB má formát "YYYY-MM-DD HH:MM:SS",
        // ale <input type="datetime-local"> chce "YYYY-MM-DDTHH:MM".
        $zacatekFmt = $jizda->getZacatek()
            ? str_replace(' ', 'T', substr($jizda->getZacatek(), 0, 16))
            : '';
        $konecFmt = $jizda->getKonec()
            ? str_replace(' ', 'T', substr($jizda->getKonec(), 0, 16))
            : '';
    ?>
        <form method="post" class="styled-panel">
            <input type="hidden" name="id" value="<?= htmlspecialchars((string)$jizda->getId()) ?>">

            <label for="id_studenta">Student</label>
            <select name="id_studenta" id="id_studenta" required>
                <option value="">&nbsp;</option>
                <?php foreach ($studenti as $s): ?>
                    <option value="<?= htmlspecialchars((string)$s['id']) ?>"
                        <?= ((int)$s['id'] === (int)$jizda->getIdStudenta()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_instruktora">Instruktor</label>
            <select name="id_instruktora" id="id_instruktora" required>
                <option value="">&nbsp;</option>
                <?php foreach ($instruktori as $i): ?>
                    <option value="<?= htmlspecialchars((string)$i['id']) ?>"
                        <?= ((int)$i['id'] === (int)$jizda->getIdInstruktora()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($i['prijmeni'] . ' ' . $i['jmeno']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_auta">Auto</label>
            <select name="id_auta" id="id_auta" required>
                <option value="">&nbsp;</option>
                <?php foreach ($auta as $a): ?>
                    <option value="<?= htmlspecialchars((string)$a['id']) ?>"
                        <?= ((int)$a['id'] === (int)$jizda->getIdAuta()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['poznavaci_znacka'] . ' — ' . $a['znacka'] . ' ' . $a['model']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="zacatek">Začátek</label>
            <input type="datetime-local" name="zacatek" id="zacatek"
                   value="<?= htmlspecialchars($zacatekFmt) ?>" required>

            <label for="konec">Konec</label>
            <input type="datetime-local" name="konec" id="konec"
                   value="<?= htmlspecialchars($konecFmt) ?>">

            <fieldset>
                <legend>Stav</legend>
                <label>
                    <input type="radio" name="stav" value="p"
                        <?= ($jizda->getStav() === 'p') ? 'checked' : '' ?>>
                    Plánovaná
                </label>
                <label>
                    <input type="radio" name="stav" value="u"
                        <?= ($jizda->getStav() === 'u') ? 'checked' : '' ?>>
                    Ukončená
                </label>
                <label>
                    <input type="radio" name="stav" value="z"
                        <?= ($jizda->getStav() === 'z') ? 'checked' : '' ?>>
                    Zrušená
                </label>
            </fieldset>

            <button type="submit">Uložit změny</button>
        </form>
    <?php } ?>
    <p class="back-link"><a href="../forms_display/form-jizdy.php">&laquo; Zpět na seznam</a></p>
<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
