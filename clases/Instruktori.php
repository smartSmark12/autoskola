<?php

class Instruktori {

    private $id;
    private $jmeno;
    private $prijmeni;
    private $telefon;
    private $email;
    private $aktivni;

    function nastavHodnoty($id = null, $jmeno = '', $prijmeni = '', $telefon = '', $email = '', $aktivni = true){
        // Id validation
        if ($id === null || filter_var($id, FILTER_VALIDATE_INT) !== false) {
            $this->id = $id;
        } else {
            throw new Exception("Non valid value");
        }
        
        // Name and surname sanitization
        $this->jmeno = filter_var($jmeno, FILTER_SANITIZE_STRING);
        $this->prijmeni = filter_var($prijmeni, FILTER_SANITIZE_STRING);

        // Phone number validation
        $pattern = '/^(\\+420\\s?|420\\s?)?\\d{3}\\s?\\d{3}\\s?\\d{3}$/';
        if ($telefon === null || $telefon === '' || preg_match($pattern, $telefon)) {
            $this->telefon = $telefon;
        } else {
            throw new Exception("Non valid value");
        }

        // Email validation: allow empty/null
        if ($email === null || $email === '' || filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Non valid value");
        }

        // Active status validation
        if (is_bool($aktivni) || $aktivni === 0 || $aktivni === 1) {
            $this->aktivni = (bool)$aktivni;
        } else {
            throw new Exception("Non valid value");
        }
    }

    function vypis(){
        // Display instructor details
        echo "ID: " . $this->id . "<br>";
        echo "Jméno: " . $this->jmeno . "<br>";
        echo "Příjmení: " . $this->prijmeni . "<br>";
        echo "Telefon: " . $this->telefon . "<br>";
        echo "Email: " . $this->email . "<br>";
        echo "Aktivní: " . ($this->aktivni ? "Ano" : "Ne") . "<br>";
    }

    function vypisOptions(){
        echo '<option value="' . htmlspecialchars($this->id) . '">' . htmlspecialchars($this->jmeno . ' ' . $this->prijmeni) . '</option>';
    }

    public function getId() { return $this->id; }
    public function getJmeno() { return $this->jmeno; }
    public function getPrijmeni() { return $this->prijmeni; }
    public function getTelefon() { return $this->telefon; }
    public function getEmail() { return $this->email; }
    public function getAktivni() { return $this->aktivni; }

}
?>