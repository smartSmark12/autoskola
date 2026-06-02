<?php

class Studenti {
    private $id;
    private $jmeno;
    private $prijmeni;
    private $datum_narozeni;
    private $telefon;
    private $email;
    private $datum_registrace;

    function nastavHodnoty($jmeno, $prijmeni, $datum_narozeni, $telefon, $email, $datum_registrace, $id = null) {

        if ($id !== null && filter_var($id, FILTER_VALIDATE_INT) === false) {
            return false;
        }
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

        $this->id = ($id === null) ? null : (int)$id;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->datum_narozeni = $datum_narozeni;
        $this->telefon = $telefon;
        $this->email = $email;
        $this->datum_registrace = $datum_registrace;
    }

    function vypis() {
        echo "<p>Jméno: ".$this->jmeno."</p>";
        echo "<p>Příjmení: ".$this->prijmeni."</p>";
        echo "<p>Datum narození: ".$this->datum_narozeni."</p>";
        echo "<p>Telefon: ".$this->telefon."</p>";
        echo "<p>Email: ".$this->email."</p>";
        echo "<p>Datum registrace: ".$this->datum_registrace."</p>";
    }

    public function vypisArticle() {
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

    public function getId() {
        return $this->id;
    }

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
}

?>
