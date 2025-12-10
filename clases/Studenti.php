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

    function nastavHodnoty($id, $jmeno, $datum_narozeni, $telefon, $email, $datum_registrace) {

        /* checkni hodnoty */ /* přidat ještě regex kontroly */
        if (gettype($id) != "integer" or is_null($id)) {
            return false;
        } else if (gettype($jmeno) != "string" or is_null($jmeno)) {
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
        $this->$id = $id;
        $this->$jmeno = $jmeno;
        $this->$datum_narozeni = $datum_narozeni;
        $this->$telefon = $telefon;
        $this->$email = $email;
        $this->$datum_registrace = $datum_registrace;
    }

    function vypis() {

    }

    function vypisOptions() {
        
    }
}

?>