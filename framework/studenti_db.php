<!-- VK -->

<?php

include_once "database.php";

class StudentiDatabase extends Database {

    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertStudent($student) {
        $query = "insert into studenti (id,jmeno,prijmeni,datum_narozeni,telefon,email,datum_registrace) values (NULL,:jmeno,:prijmeni,:datum_narozeni,:telefon,:email,:datum_registrace)";
        
        $sql = $this->connection->prepare($query);

        $sql->bindParam(":jmeno", $student->get_jmeno());
        $sql->bindParam(":prijmeni", $student->get_prijmeni());
        $sql->bindParam(":datum_narozeni", $student->get_datum_narozeni());
        $sql->bindParam(":telefon", $student->get_telefon());
        $sql->bindParam(":email", $student->get_email());
        $sql->bindParam(":datum_registrace", $student->get_datum_registrace());

        if($sql->execute()){return $this->connection->lastInsertId();}
        else {return false;}
    }
}

?>