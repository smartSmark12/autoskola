<?php

include_once "database.php";

class InstruktoriDatabase extends Database {
    protected $connection;

    function __construct() {        $this->connection = self::connect();
    }

    public function insertInstruktor($instruktor) {
        $res = $this->connection->query("SELECT MAX(id) AS maxid FROM instruktori");
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $nextId = (int)$row['maxid'] + 1;

        $query = "INSERT INTO instruktori (id, jmeno, prijmeni, telefon, email, aktivni) VALUES (:id, :jmeno, :prijmeni, :telefon, :email, :aktivni)";
        $sql = $this->connection->prepare($query);

        $sql->bindValue(":id", $nextId, PDO::PARAM_INT);
        $sql->bindValue(":jmeno", $instruktor->getJmeno());
        $sql->bindValue(":prijmeni", $instruktor->getPrijmeni());
        $sql->bindValue(":telefon", $instruktor->getTelefon());
        $sql->bindValue(":email", $instruktor->getEmail());
        $sql->bindValue(":aktivni", $instruktor->getAktivni(), PDO::PARAM_INT);

        if ($sql->execute()) {
            return $nextId;
        } else {
            return false;
        }
    }
}