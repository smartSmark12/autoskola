<?php
include_once __DIR__ . "/database.php";

// Přístupová vrstva k tabulce `instruktori`. Připojení dědí z Database.
class InstruktoriDatabase extends Database {
    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertInstruktor($instruktor) {
        $query = "INSERT INTO instruktori (id, jmeno, prijmeni, telefon, email, aktivni)
                  VALUES (NULL, :jmeno, :prijmeni, :telefon, :email, :aktivni)";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":jmeno", $instruktor->getJmeno());
        $sql->bindValue(":prijmeni", $instruktor->getPrijmeni());
        $sql->bindValue(":telefon", $instruktor->getTelefon());
        $sql->bindValue(":email", $instruktor->getEmail());
        $sql->bindValue(":aktivni", $instruktor->getAktivni() ? 1 : 0, PDO::PARAM_INT);

        if ($sql->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }

    // ORDER BY se nedá bindovat přes prepared statement, proto whitelist.
    public function getAll($orderBy = "prijmeni ASC") {
        $allowed = ["id", "jmeno", "prijmeni", "telefon", "email", "aktivni"];

        $parts = explode(" ", $orderBy);
        $column = $parts[0];
        $direction = strtoupper($parts[1] ?? "ASC");

        if (!in_array($column, $allowed, true)) {
            $column = "prijmeni";
        }
        if (!in_array($direction, ["ASC", "DESC"], true)) {
            $direction = "ASC";
        }

        $query = "SELECT * FROM instruktori ORDER BY $column $direction";
        $sql = $this->connection->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Instruktori");
        return $sql->fetchAll();
    }

    // Vrací objekt Instruktori, nebo null pokud záznam neexistuje.
    public function getById($id) {
        $query = "SELECT * FROM instruktori WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Instruktori");
        $result = $sql->fetch();
        return $result === false ? null : $result;
    }

    public function update($instruktor) {
        $query = "UPDATE instruktori
                  SET jmeno = :jmeno,
                      prijmeni = :prijmeni,
                      telefon = :telefon,
                      email = :email,
                      aktivni = :aktivni
                  WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $instruktor->getId(), PDO::PARAM_INT);
        $sql->bindValue(":jmeno", $instruktor->getJmeno());
        $sql->bindValue(":prijmeni", $instruktor->getPrijmeni());
        $sql->bindValue(":telefon", $instruktor->getTelefon());
        $sql->bindValue(":email", $instruktor->getEmail());
        $sql->bindValue(":aktivni", $instruktor->getAktivni() ? 1 : 0, PDO::PARAM_INT);
        return $sql->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM instruktori WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }
}
?>
