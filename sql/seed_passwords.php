<?php
// Jednorázový seed: nastaví unikátní dočasné heslo všem záznamům, které heslo nemají.
// Spusť: php sql/seed_passwords.php
require_once __DIR__ . "/../framework/database.php";

$pdo = Database::connect();
$celkem = 0;

foreach (["studenti", "instruktori"] as $tabulka) {
    $select = $pdo->query("SELECT id, email FROM `$tabulka` WHERE heslo IS NULL OR heslo = '' ORDER BY id");
    $rows = $select->fetchAll(PDO::FETCH_ASSOC);

    $update = $pdo->prepare("UPDATE `$tabulka` SET heslo = :hash WHERE id = :id");
    foreach ($rows as $row) {
        $docasneHeslo = bin2hex(random_bytes(8));
        $update->bindValue(":hash", password_hash($docasneHeslo, PASSWORD_DEFAULT));
        $update->bindValue(":id", (int)$row["id"], PDO::PARAM_INT);
        $update->execute();

        echo $tabulka . " #" . $row["id"] . " (" . ($row["email"] ?: "bez emailu") . "): "
           . $docasneHeslo . PHP_EOL;
        $celkem++;
    }
}

echo "Hotovo. Nastaveno dočasných hesel: " . $celkem . PHP_EOL;
