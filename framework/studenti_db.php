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

    public function readStudents($sortBy = "prijmeni") {

        /* kontrola kvůli injection ✨✨😭 */
        $allowed = ["id","jmeno","prijmeni","datum_narozeni","datum_registrace"];

        if(!in_array($sortBy, $allowed)){
            $sortBy = "prijmeni";
        }

        $query = "SELECT * FROM studenti ORDER BY $sortBy";

        $sql = $this->connection->prepare($query);
        $sql->execute();

        $sql->setFetchMode(PDO::FETCH_CLASS, "Studenti");

        return $sql->fetchAll();
    }

    public function readStudent($id) {
        $query = "SELECT * FROM studenti WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Studenti");
        $result = $sql->fetch();
        return $result === false ? null : $result;
    }

    public function update($student) {
        $query = "UPDATE studenti
                  SET jmeno            = :jmeno,
                      prijmeni         = :prijmeni,
                      datum_narozeni   = :datum_narozeni,
                      telefon          = :telefon,
                      email            = :email,
                      datum_registrace = :datum_registrace
                  WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id",               $student->getId());
        $sql->bindValue(":jmeno",            $student->get_jmeno());
        $sql->bindValue(":prijmeni",         $student->get_prijmeni());
        $sql->bindValue(":datum_narozeni",   $student->get_datum_narozeni());
        $sql->bindValue(":telefon",          $student->get_telefon());
        $sql->bindValue(":email",            $student->get_email());
        $sql->bindValue(":datum_registrace", $student->get_datum_registrace());
        return $sql->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM studenti WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }
}

?>