<!-- VK -->

<?php

include_once "database.php";

class StudentiDatabase extends Database {

    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertStudent($student) {
        $query =    "INSERT INTO studenti (id,jmeno,prijmeni,datum_narozeni,telefon,email,datum_registrace)
                    VALUES (NULL,:jmeno,:prijmeni,:datum_narozeni,:telefon,:email,:datum_registrace)";
        
        $sql = $this->connection->prepare($query);

        /* get data from student obj ig */
        $jmeno = $student->get_jmeno();
        $prijmeni = $student->get_prijmeni();
        $datum_narozeni = $student->get_datum_narozeni();
        $telefon = $student->get_telefon();
        $email = $student->get_email();
        $datum_registrace = $student->get_datum_registrace();

        $sql->bindParam(":jmeno", $jmeno);
        $sql->bindParam(":prijmeni", $prijmeni);
        $sql->bindParam(":datum_narozeni", $datum_narozeni);
        $sql->bindParam(":telefon", $telefon);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":datum_registrace", $datum_registrace);

        if($sql->execute()){return $this->connection->lastInsertId();}
        else {return false;}
    }
}

?>