<?php
$pageTitle   = 'Administrativa Autoškoly';
$pageHeading = 'Celková administrativa';
$pageActive  = 'administrativa';
$rel         = '../';
include __DIR__ . '/../bordel/_layout_top.php';
?>

<div class="admin-grid">
    <div class="admin-card">
        <h2>Auta</h2>
        <p>Správa vozového parku</p>
        <a href="../forms_display/form-auta.php">Přejít na výpis aut &rsaquo;</a>
    </div>
    <div class="admin-card">
        <h2>Studenti</h2>
        <p>Správa žáků autoškoly</p>
        <a href="../forms_display/form-studenti.php">Přejít na výpis studentů &rsaquo;</a>
    </div>
    <div class="admin-card">
        <h2>Instruktoři</h2>
        <p>Správa zaměstnanců</p>
        <a href="../forms_display/form-instruktori.php">Přejít na výpis instruktorů &rsaquo;</a>
    </div>
    <div class="admin-card">
        <h2>Jízdy</h2>
        <p>Správa plánu jízd</p>
        <a href="../forms_display/form-jizdy.php">Přejít na výpis jízd &rsaquo;</a>
    </div>
</div>

<p class="back-link"><a href="../index.php">&laquo; Zpět na hlavní menu</a></p>

<?php include __DIR__ . '/../bordel/_layout_bottom.php'; ?>
