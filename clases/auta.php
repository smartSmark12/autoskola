<?php
    require_once "../framework/auta_db.php";
class Auta {
    public $id;           
    public $znacka;
    public $model;
    public $poznavaci_znacka;
    public $aktivni;

    public function nastavHodnoty($data) {
        if (!isset($data["znacka"]) || trim($data["znacka"]) === '') {
            throw new Exception("Značka je povinná");
        }
        $this->znacka = htmlspecialchars(trim($data["znacka"]));

        if (!isset($data["model"]) || trim($data["model"]) === '') {
            throw new Exception("Model je povinný");
        }
        $this->model = htmlspecialchars(trim($data["model"]));

       if (!isset($data["poznavaci_znacka"]) || !preg_match("/^[0-9A-Z]{3,10}$/", strtoupper(trim($data["poznavaci_znacka"])))) {
    throw new Exception("SPZ musí být 3–10 znaků (0-9, A-Z)");
}
$this->poznavaci_znacka = strtoupper(trim($data["poznavaci_znacka"]));

if (!isset($data["aktivni"]) || !in_array($data["aktivni"], [0,1,"0","1"], true)) {
    throw new Exception("Neplatná hodnota aktivní");
}
$this->aktivni = (int)$data["aktivni"];
    }

    public function getId() { return $this->id; }
    public function getZnacka() { return $this->znacka; }
    public function getModel() { return $this->model; }
    public function getPoznavaciZnacka() { return $this->poznavaci_znacka; }
    public function getAktivni() { return $this->aktivni; } 

public function vypis() {
    echo "<article class='auto-karta'>";
    echo "<h2>" . htmlspecialchars($this->znacka) . "</h2>";
    echo "<h2>" . htmlspecialchars($this->model) . "</h2>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . ($this->id ?? "neuvedeno") . "</li>";
    echo "<li><strong>SPZ:</strong> " . htmlspecialchars($this->poznavaci_znacka ?? "neuvedeno") . "</li>";
    echo "<li><strong>Stav:</strong> " . (isset($this->aktivni) ? ($this->aktivni ? "Aktivní" : "Neaktivní") : "neuvedeno") . "</li>";
    echo "</ul>";
    echo "</article>";
}
    public function vypisOptions() {
    return '<option value="' . htmlspecialchars($this->id) . '">' .
           htmlspecialchars($this->znacka . ' ' . $this->model) .
           '</option>';
}
public function vypisAdmin() {
    echo "<article class='auto-karta'>";
    echo "<h2>" . htmlspecialchars($this->znacka) . "</h2>";
    echo "<h2>" . htmlspecialchars($this->model) . "</h2>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . $this->id . "</li>";
    echo "<li><strong>SPZ:</strong> " . htmlspecialchars($this->poznavaci_znacka) . "</li>";
    echo "<li><strong>Stav:</strong> " . ($this->aktivni ? "Aktivní" : "Neaktivní") . "</li>";
    echo "</ul>";

    echo "<a href='../forms_edit/form-auta.php?id=".$this->id."'>✏️ Upravit</a> | ";
    echo "<a href='../forms_remove/form-auta.php?id=".$this->id."'>🗑️ Smazat</a>";

    echo "</article>";
}
}
?>