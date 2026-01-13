<?php
    class Auta {
        private $id;
        private $znacka;
        private $model;
        private $poznavaci_znacka;
        private $aktivni;


    public function nastavHodnoty($data) {
        if (isset($data["id"]) && $data["id"] !== "") {
            if(!ctype_digit($data["id"])) return false;
            $this->id = intval($data["id"]);
        }

    if (!isset($data["znacka"]) || trim($data["znacka"]) == "") return false;
    $this->znacka = htmlspecialchars(trim($data["znacka"]));

    if(!isset($data["model"]) || trim($data["model"]) == "") return false;
    $this->model = htmlspecialchars(trim($data["model"]));

    if(!isset($data["poznavaci_znacka"]) || trim($data["poznavaci_znacka"]) == "") return false;
    if(!preg_match("/^[0-9A-Z]{3,10}$/", strtoupper($data["poznavaci_znacka"]))) return false;
    $this->poznavaci_znacka = strtoupper($data["poznavaci_znacka"]);

    if(!isset($data["aktivni"])) return false;
    if(!in_array($data["aktivni"], ["0","1"], true)) return false;
    $this->aktivni = intval($data["aktivni"]);

    return true;
    }

    public function vypis() {
        echo "<h3>AUTO ID: {$this->id}</h3>";
        echo "<p><strong>Značka:</strong> {$this->znacka}</p>";
        echo "<p><strong>Model:</strong> {$this->model}</p>";
        echo "<p><strong>SPZ:</strong> {$this->poznavaci_znacka}</p>";
        echo "<p><strong>Aktivní:</strong> " . ($this->aktivni ? "Ano" : "Ne") . "</p>";
    }

    public function vypisOptions() {
        echo "<option value='{$this->id}'>{$this->znacka} - {$this->model}</option>";
    }
}    