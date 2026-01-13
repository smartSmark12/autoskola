<?php

include_once "database.php";

class InstruktoriDatabase extends Database {
    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertInstruktor($instruktor) {
        $query = "INSERT INTO instruktori (id, jmeno, prijmeni, telefon, email, aktivni) VALUES (:id, :jmeno, :prijmeni, :telefon, :email, :aktivni)";

        $sql = $this->connection->prepare($query);

        if (is_array($instruktor)) {
            $jmeno = isset($instruktor['jmeno']) ? $instruktor['jmeno'] : null;
            $prijmeni = isset($instruktor['prijmeni']) ? $instruktor['prijmeni'] : null;
            $telefon = isset($instruktor['telefon']) ? $instruktor['telefon'] : null;
            $email = isset($instruktor['email']) ? $instruktor['email'] : null;
            $aktivni = isset($instruktor['aktivni']) ? $instruktor['aktivni'] : 1;
        } else {
            $jmeno = method_exists($instruktor, 'getJmeno') ? $instruktor->getJmeno() : null;
            $prijmeni = method_exists($instruktor, 'getPrijmeni') ? $instruktor->getPrijmeni() : null;
            $telefon = method_exists($instruktor, 'getTelefon') ? $instruktor->getTelefon() : null;
            $email = method_exists($instruktor, 'getEmail') ? $instruktor->getEmail() : null;
            $aktivni = method_exists($instruktor, 'getAktivni') ? ($instruktor->getAktivni() ? 1 : 0) : 1;
        }

        try {
            $this->connection->beginTransaction();

            $res = $this->connection->query("SELECT COALESCE(MAX(id), 0) AS maxid FROM instruktori");
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $nextId = (int)$row['maxid'] + 1;

            $sql->bindValue(":id", $nextId, PDO::PARAM_INT);
            $sql->bindValue(":jmeno", $jmeno);
            $sql->bindValue(":prijmeni", $prijmeni);
            $sql->bindValue(":telefon", $telefon);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":aktivni", $aktivni, PDO::PARAM_INT);

            if ($sql->execute()) {
                $this->connection->commit();
                return $nextId;
            } else {
                $this->connection->rollBack();
                return false;
            }
        } catch (Exception $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            return false;
        }
    }
}

?>
