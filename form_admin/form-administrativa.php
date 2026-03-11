<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Administrativa Autoškoly</title>
    <link rel="stylesheet" href="../bordel/style.css">
    <style>
        .admin-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .admin-card { background: #5c5c5c; padding: 20px; border-radius: 8px; text-align: center; }
        .admin-card a { display: block; background: gray; padding: 10px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Celková administrativa</h1>
    <main class="admin-grid">
        <div class="admin-card">
            <h2>Auta</h2>
            <p>Správa vozového parku</p>
            <a href="../forms_display/form-auta.php">Přejít na výpis aut</a>
        </div>
        <div class="admin-card">
            <h2>Studenti</h2>
            <p>Správa žáků autoškoly</p>
            <a href="../forms_display/form-studenti.php">Přejít na výpis studentů</a>
        </div>
        <div class="admin-card">
            <h2>Instruktoři</h2>
            <p>Správa zaměstnanců</p>
            <a href="../forms_display/form-instruktori.php">Přejít na výpis instruktorů</a>
        </div>
    </main>
    <p style="text-align: center;"><a href="../index.php">Zpět na hlavní menu</a></p>
</body>
</html>