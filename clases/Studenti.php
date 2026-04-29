<!-- VK -->

<?php

class Studenti {
    private $id;
    private $jmeno;
    private $prijmeni;
    private $datum_narozeni;
    private $telefon;
    private $email;
    private $datum_registrace;

    function nastavHodnoty($jmeno, $prijmeni, $datum_narozeni, $telefon, $email, $datum_registrace) {

        /* checkni hodnoty */ /* přidat ještě regex kontroly */
        /* if (gettype($id) != "integer" or is_null($id)) {
            return false; */
        if (gettype($jmeno) != "string" or is_null($jmeno)) {
            return false;
        } else if (gettype($prijmeni) != "string" or is_null($prijmeni)) {
            return false;
        } else if (gettype($datum_narozeni) != "string" or is_null($datum_narozeni)) {
            return false;
        } else if (gettype($telefon) != "string" or is_null($telefon)) {
            return false;
        } else if (gettype($email) != "string" or is_null($email)) {
            return false;
        } else if (gettype($datum_registrace) != "string" or is_null($datum_registrace)) {
            return false;
        }

        /* nastav, pokud projdou všechny kontroly */
        //$this->$id = $id;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->datum_narozeni = $datum_narozeni;
        $this->telefon = $telefon;
        $this->email = $email;
        $this->datum_registrace = $datum_registrace;
    }

    function vypis() {
        /* vypíše echem data do article */
        //echo "<h3>ID: ".$this->$id;
        echo "<p>Jméno: ".$this->jmeno."</p>";
        echo "<p>Příjmení: ".$this->prijmeni."</p>";
        echo "<p>Datum narození: ".$this->datum_narozeni."</p>";
        echo "<p>Telefon: ".$this->telefon."</p>";
        echo "<p>Email: ".$this->email."</p>";
        echo "<p>Datum registrace: ".$this->datum_registrace."</p>";
    }

    public function vypisArticle() {
        /* na použití pro actually useful formát */
        echo "
        <article class='display-card'>
            <h2>".$this->jmeno." ".$this->prijmeni."</h2>
            <p><strong>ID:</strong> ".$this->id."</p>
            <p><strong>Datum narození:</strong> ".$this->datum_narozeni."</p>
            <p><strong>Telefon:</strong> ".$this->telefon."</p>
            <p><strong>Email:</strong> ".$this->email."</p>
            <p><strong>Registrován:</strong> ".$this->datum_registrace."</p>
            <a href='../forms_edit/form-studenti.php?id=".$this->id."'>Upravit</a>
            <a href='../forms_remove/form-studenti.php?id=".$this->id."'>Smazat</a>
        </article>
        ";
    }

    /* toto bolí */
    public function get_jmeno() {
        return $this->jmeno;
    }

    public function get_prijmeni() {
        return $this->prijmeni;
    }

    public function get_datum_narozeni() {
        return $this->datum_narozeni;
    }

    public function get_telefon() {
        return $this->telefon;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_datum_registrace() {
        return $this->datum_registrace;
    }

    /* function vypisOptions() {
        echo "<options value='{$this->id}'>{$this->jmeno} {$this->prijmeni}</options>"; // ukradeno od simona xd
    } */
}

?>