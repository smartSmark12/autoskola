<?php

// Datová třída pro jednu jízdu — odpovídá tabulce `jizdy`.
// Při načtení přes JOIN (getAll/getById z JizdyDatabase) se navíc
// naplní pole student_*, instruktor_*, znacka/model/poznavaci_znacka.
class Jizdy {
    private $id;
    private $id_studenta;
    private $id_instruktora;
    private $id_auta;
    private $zacatek;
    private $konec;
    private $stav;

    // doplňková data z JOINu — null, když se načítalo bez něj
    private $student_jmeno;
    private $student_prijmeni;
    private $instruktor_jmeno;
    private $instruktor_prijmeni;
    private $znacka;
    private $model;
    private $poznavaci_znacka;

    // Naplní objekt z formulářových dat a zkontroluje formáty regexy
    // (datetime, ENUM stav, FK jako kladná čísla). Vrací false při chybě.
    function nastavHodnoty($id, $id_studenta, $id_instruktora, $id_auta, $zacatek, $konec = null, $stav = 'p') {
        if (!($id === null || filter_var($id, FILTER_VALIDATE_INT) !== false)) {
            return false;
        }
        $this->id = ($id === null) ? null : (int)$id;

        // FK musí být kladné celé číslo
        foreach ([$id_studenta, $id_instruktora, $id_auta] as $fk) {
            if (filter_var($fk, FILTER_VALIDATE_INT) === false || (int)$fk <= 0) {
                return false;
            }
        }
        $this->id_studenta    = (int)$id_studenta;
        $this->id_instruktora = (int)$id_instruktora;
        $this->id_auta        = (int)$id_auta;

        // YYYY-MM-DD HH:MM[:SS], případně s 'T' (HTML5 datetime-local)
        $datetimePattern = '/^\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}(:\d{2})?$/';
        if (!is_string($zacatek) || !preg_match($datetimePattern, $zacatek)) {
            return false;
        }
        $this->zacatek = str_replace('T', ' ', $zacatek);

        if ($konec === null || $konec === '') {
            $this->konec = null;
        } elseif (is_string($konec) && preg_match($datetimePattern, $konec)) {
            $this->konec = str_replace('T', ' ', $konec);
            // konec musí být striktně po začátku
            if (strtotime($this->konec) <= strtotime($this->zacatek)) {
                return false;
            }
        } else {
            return false;
        }

        if (!in_array($stav, ['p', 'u', 'z'], true)) {
            return false;
        }
        $this->stav = $stav;

        return true;
    }

    private function stavText() {
        switch ($this->stav) {
            case 'p': return 'Plánovaná';
            case 'u': return 'Ukončená';
            case 'z': return 'Zrušená';
        }
        return '';
    }

    // Základní výpis — používá se po vložení a po smazání pro náhled.
    // Pokud byly naplněny i JOIN sloupce, ukáže rovnou jména a SPZ;
    // jinak fallback na ID studenta/instruktora/auta.
    function vypis() {
        echo '<article class="display-card">';
        echo '<p><strong>ID:</strong> ' . htmlspecialchars((string)$this->id) . '</p>';
        echo '<p><strong>Začátek:</strong> ' . htmlspecialchars((string)$this->zacatek) . '</p>';
        echo '<p><strong>Konec:</strong> ' . htmlspecialchars((string)($this->konec ?? '—')) . '</p>';
        echo '<p><strong>Stav:</strong> ' . htmlspecialchars($this->stavText()) . '</p>';

        if ($this->student_prijmeni !== null) {
            echo '<p><strong>Student:</strong> '
               . htmlspecialchars($this->student_prijmeni . ' ' . $this->student_jmeno) . '</p>';
        } else {
            echo '<p><strong>ID studenta:</strong> ' . htmlspecialchars((string)$this->id_studenta) . '</p>';
        }
        if ($this->instruktor_prijmeni !== null) {
            echo '<p><strong>Instruktor:</strong> '
               . htmlspecialchars($this->instruktor_prijmeni . ' ' . $this->instruktor_jmeno) . '</p>';
        } else {
            echo '<p><strong>ID instruktora:</strong> ' . htmlspecialchars((string)$this->id_instruktora) . '</p>';
        }
        if ($this->znacka !== null) {
            echo '<p><strong>Auto:</strong> '
               . htmlspecialchars($this->poznavaci_znacka . ' — ' . $this->znacka . ' ' . $this->model) . '</p>';
        } else {
            echo '<p><strong>ID auta:</strong> ' . htmlspecialchars((string)$this->id_auta) . '</p>';
        }
        echo '</article>';
    }

    // Verze pro administrační výpis — přidává odkazy na editaci a smazání.
    function vypisSOdkazy() {
        echo '<article class="display-card">';
        echo '<p><strong>ID:</strong> ' . htmlspecialchars((string)$this->id) . '</p>';
        echo '<p><strong>Začátek:</strong> ' . htmlspecialchars((string)$this->zacatek) . '</p>';
        echo '<p><strong>Konec:</strong> ' . htmlspecialchars((string)($this->konec ?? '—')) . '</p>';
        echo '<p><strong>Stav:</strong> ' . htmlspecialchars($this->stavText()) . '</p>';
        if ($this->student_prijmeni !== null) {
            echo '<p><strong>Student:</strong> '
               . htmlspecialchars($this->student_prijmeni . ' ' . $this->student_jmeno) . '</p>';
        }
        if ($this->instruktor_prijmeni !== null) {
            echo '<p><strong>Instruktor:</strong> '
               . htmlspecialchars($this->instruktor_prijmeni . ' ' . $this->instruktor_jmeno) . '</p>';
        }
        if ($this->znacka !== null) {
            echo '<p><strong>Auto:</strong> '
               . htmlspecialchars($this->poznavaci_znacka . ' — ' . $this->znacka . ' ' . $this->model) . '</p>';
        }
        echo '<p class="card-actions">';
        echo '<a href="../forms_edit/form-jizdy.php?id=' . urlencode((string)$this->id) . '">Editovat</a> | ';
        echo '<a href="../forms_remove/form-jizdy.php?id=' . urlencode((string)$this->id) . '">Smazat</a>';
        echo '</p>';
        echo '</article>';
    }

    public function getId()              { return $this->id; }
    public function getIdStudenta()      { return $this->id_studenta; }
    public function getIdInstruktora()   { return $this->id_instruktora; }
    public function getIdAuta()          { return $this->id_auta; }
    public function getZacatek()         { return $this->zacatek; }
    public function getKonec()           { return $this->konec; }
    public function getStav()            { return $this->stav; }
}
?>
