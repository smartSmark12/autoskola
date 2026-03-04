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

        $sql->bindParam(":jmeno", $student->jmeno);
        $sql->bindParam(":prijmeni", $student->prijmeni);
        $sql->bindParam(":datum_narozeni", $student->datum_narozeni);
        $sql->bindParam(":telefon", $student->telefon);
        $sql->bindParam(":email", $student->email);
        $sql->bindParam(":datum_registrace", $student->datum_registrace);

        if($sql->execute()){return $this->connection->lastInsertId();}
        else {return false;}
    }
}

?>