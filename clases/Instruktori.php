<?php

class Instruktori(){

    private $id;
    private $jmeno;
    private $prijmeni;
    private $telefon;
    private $email;
    private $aktivni;

    function nastavHodnoty($id, $jmeno, $prijmeni, $telefon, $email, $aktivni){

        $this->id = $id;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->telefon = $telefon;
        $this->email = $email;
        $this->aktivni = $aktivni;

        if (!filter_var($id, FILTER_VALIDATE_INT) === false) {
            $this->id = $id;
        } else {
            throw new Exception("Non valid value");
        }
        
        $jmeno = filter_var($jmeno, FILTER_SANITIZE_STRING);
        $prijmeni = filter_var($prijmeni, FILTER_SANITIZE_STRING);

        $pattern = '/^(\\+420\\s?|420\\s?)?\\d{3}\\s?\\d{3}\\s?\\d{3}$/';
        if (preg_match($pattern, $telefon)) {
            $this->telefon = $telefon;
        } else {
            throw new Exception("Non valid value");
        }

    }

    function vypis(){
        
    }

    function vypisOptions(){
        
    }
}
?>