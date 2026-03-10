<?php
include_once __DIR__ . "/database.php";

// Database access layer for the instruktori table
class InstruktoriDatabase extends Database {
    private $connection;

    // Establish PDO connection on instantiation
    function __construct() {
        $this->connection = $this->connect();
    }

    // Inserts a new instructor with auto-generated ID using transaction
    public function insertInstruktor($instruktor) {
        $query = "INSERT INTO instruktori (id, jmeno, prijmeni, telefon, email, aktivni)
                  VALUES (:id, :jmeno, :prijmeni, :telefon, :email, :aktivni)";

        $sql = $this->connection->prepare($query);

        // Extract values via getters from Instruktori object
        $jmeno = $instruktor->getJmeno();
        $prijmeni = $instruktor->getPrijmeni();
        $telefon = $instruktor->getTelefon();
        $email = $instruktor->getEmail();
        $aktivni = $instruktor->getAktivni() ? 1 : 0;

        try {
            $this->connection->beginTransaction();

            // Determine next ID as max(id) + 1
            $res = $this->connection->query("SELECT COALESCE(MAX(id), 0) AS maxid FROM instruktori");
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $nextId = (int)$row['maxid'] + 1;

            // Bind all parameters with appropriate types
            $sql->bindValue(":id", $nextId, PDO::PARAM_INT);
            $sql->bindValue(":jmeno", $jmeno);
            $sql->bindValue(":prijmeni", $prijmeni);
            $sql->bindValue(":telefon", $telefon);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":aktivni", $aktivni, PDO::PARAM_INT);

            if ($sql->execute()) {
                $this->connection->commit();
                return $nextId;
            }
            $this->connection->rollBack();
            return false;
        } catch (Exception $e) {
            if ($this->connection->inTransaction()) $this->connection->rollBack();
            return false;
        }
    }

    // Fetches all instructors, returns array of Instruktori objects
    public function getAll($orderBy = "prijmeni ASC") {
        $query = "SELECT * FROM instruktori ORDER BY $orderBy";
        $sql = $this->connection->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Instruktori");
        return $sql->fetchAll();
    }

    // Deletes an instructor by ID using prepared statement
    public function delete($id) {
        $query = "DELETE FROM instruktori WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }
}
?>
