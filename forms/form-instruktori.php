<?php
require_once __DIR__ . "/../framework/instruktori_db.php";
require_once __DIR__ . "/../clases/Instruktori.php";

$db = new InstruktoriDatabase();
$zprava = '';
$vlozeny = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instruktor = new Instruktori();
    $jmeno    = $_POST['jmeno']    ?? '';
    $prijmeni = $_POST['prijmeni'] ?? '';
    $telefon  = $_POST['telefon']  ?? '';
    $email    = $_POST['email']    ?? '';

    if ($instruktor->nastavHodnoty(null, $jmeno, $prijmeni, $telefon, $email, true) === false) {
        $zprava = "<div class='msg-err'>Chyba: zadané hodnoty nejsou platné</div>";
    } else {
        $instruktor_id = $db->insertInstruktor($instruktor);
        if ($instruktor_id !== false && $instruktor_id !== 0) {
            $zprava = "<div class='msg-ok'>Data byla vložena</div>";
            $vlozeny = $db->getById((int)$instruktor_id);
        } else {
            $zprava = "<div class='msg-err'>Data nebyla vložena</div>";
        }
    }
}

$pageTitle   = 'Vložení instruktora';
$pageHeading = 'Přidání instruktora';
$pageActive  = 'vlozeni';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<?= $zprava ?>
<?php if ($vlozeny) { $vlozeny->vypis(); } ?>

<form method="post" onsubmit="return kontrola();" class="styled-panel">
    <label for="jmeno">Jméno</label>
    <input type="text" name="jmeno" maxlength="50" required>
    <label for="prijmeni">Příjmení</label>
    <input type="text" name="prijmeni" maxlength="50" required>
    <label for="telefon">Telefon</label>
    <input type="text" name="telefon" maxlength="20" placeholder="+420 123 456 789">
    <label for="email">E-mail</label>
    <input type="text" name="email" maxlength="100">
    <button type="submit">Vložit instruktora</button>
</form>

<p class="back-link"><a href="../forms_display/form-instruktori.php">&laquo; Zpět na výpis</a></p>

<script>
function kontrola() {
    var jmeno = document.querySelector('input[name="jmeno"]').value.trim();
    var prijmeni = document.querySelector('input[name="prijmeni"]').value.trim();
    if (!jmeno || !prijmeni) {
        alert('Vyplňte jméno i příjmení.');
        return false;
    }
    return true;
}
</script>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
