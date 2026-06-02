<?php
include_once __DIR__ . "/database.php";

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

    // Vrátí asociativní pole (vč. sloupce heslo) podle emailu, nebo null. Pro login.
    public function findByEmail($email) {
        $query = "SELECT * FROM instruktori WHERE email = :email LIMIT 1";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":email", $email);
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    // Registrace instruktora: vloží nový záznam s hashem hesla. Vrací nové ID nebo false.
    public function registruj($jmeno, $prijmeni, $email, $hesloHash) {
        $query = "INSERT INTO instruktori (id, jmeno, prijmeni, telefon, email, heslo, aktivni)
                  VALUES (NULL, :jmeno, :prijmeni, NULL, :email, :heslo, 1)";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":jmeno", $jmeno);
        $sql->bindValue(":prijmeni", $prijmeni);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":heslo", $hesloHash);
        if ($sql->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
}
?>
