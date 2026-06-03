<?php
require_once __DIR__ . "/../framework/auth.php";
Auth::requireInstruktor("../");
require_once __DIR__ . "/../framework/jizdy_db.php";
require_once __DIR__ . "/../clases/Jizdy.php";

$db = new JizdyDatabase();

$message = '';
$vlozena = null;
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jizda = new Jizdy();
    $ok = $jizda->nastavHodnoty(
        null,
        $_POST['id_studenta']    ?? '',
        Auth::id(),                       // instruktor smí zadávat jen své jízdy
        $_POST['id_auta']        ?? '',
        $_POST['zacatek']        ?? '',
        $_POST['konec']          ?? '',
        $_POST['stav']           ?? 'p'
    );

    if ($ok === false) {
        $message = '<h2>Chyba: zadané hodnoty nejsou platné</h2>';
        $old = $_POST;
    } else {
        $newId = $db->insertJizda($jizda);
        if ($newId !== false && $newId !== 0) {
            $message = '<h2>Data byla vložena</h2>';
            $vlozena = $db->getById((int)$newId);
        } else {
            $message = '<h2>Data nebyla vložena</h2>';
            $old = $_POST;
        }
    }
}

$studenti    = $db->getStudentiForSelect();
$instruktori = $db->getInstruktoriForSelect();
$auta        = $db->getAutaForSelect();

$pageTitle   = 'Vložení jízdy';
$pageHeading = 'Vložení jízdy';
$pageActive  = 'vlozeni';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>
        <?php
        if ($message !== '') {
            $cls = (strpos($message, 'Chyba') !== false || strpos($message, 'nebyla') !== false) ? 'msg-err' : 'msg-ok';
            echo "<div class='$cls'>" . strip_tags($message) . "</div>";
        }
        if ($vlozena) {
            $vlozena->vypis();
        }
        ?>
        <form method="post" class="styled-panel">
            <label for="id_studenta">Student</label>
            <select name="id_studenta" id="id_studenta" required>
                <option value="">&nbsp;</option>
                <?php foreach ($studenti as $s): ?>
                    <option value="<?= htmlspecialchars((string)$s['id']) ?>"
                        <?= (isset($old['id_studenta']) && (string)$old['id_studenta'] === (string)$s['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_instruktora">Instruktor</label>
            <input type="text" id="id_instruktora" value="<?= htmlspecialchars(Auth::celeJmeno()) ?>" disabled>
            <small>Jízda bude přiřazena vám jako instruktorovi.</small>

            <label for="id_auta">Auto</label>
            <select name="id_auta" id="id_auta" required>
                <option value="">&nbsp;</option>
                <?php foreach ($auta as $a): ?>
                    <option value="<?= htmlspecialchars((string)$a['id']) ?>"
                        <?= (isset($old['id_auta']) && (string)$old['id_auta'] === (string)$a['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['poznavaci_znacka'] . ' — ' . $a['znacka'] . ' ' . $a['model']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="zacatek">Začátek</label>
            <input type="datetime-local" name="zacatek" id="zacatek"
                value="<?= htmlspecialchars($old['zacatek'] ?? '') ?>" required>

            <label for="konec">Konec</label>
            <input type="datetime-local" name="konec" id="konec"
                value="<?= htmlspecialchars($old['konec'] ?? '') ?>">

            <fieldset>
                <legend>Stav</legend>
                <label>
                    <input type="radio" name="stav" value="p"
                        <?= (($old['stav'] ?? 'p') === 'p') ? 'checked' : '' ?>>
                    Plánovaná
                </label>
                <label>
                    <input type="radio" name="stav" value="u"
                        <?= (($old['stav'] ?? '') === 'u') ? 'checked' : '' ?>>
                    Ukončená
                </label>
                <label>
                    <input type="radio" name="stav" value="z"
                        <?= (($old['stav'] ?? '') === 'z') ? 'checked' : '' ?>>
                    Zrušená
                </label>
            </fieldset>

            <button type="submit">Vložit jízdu</button>
        </form>
        <p class="back-link">
            <a href="../forms_display/form-jizdy.php">&laquo; Zpět na výpis</a>
            <a href="../index.php">Hlavní menu</a>
        </p>
<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>