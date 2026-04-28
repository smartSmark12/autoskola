<?php

include_once "database.php";

class AutaDatabase extends Database {
    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertAuto($auto) {
        $query = "INSERT INTO auta (id, znacka, model, poznavaci_znacka, aktivni)
                  VALUES (:id, :znacka, :model, :poznavaci_znacka, :aktivni)";

        $sql = $this->connection->prepare($query);

        if (is_array($auto)) {
            $znacka = isset($auto['znacka']) ? $auto['znacka'] : null;
            $model = isset($auto['model']) ? $auto['model'] : null;
            $poznavaci_znacka = isset($auto['poznavaci_znacka']) ? $auto['poznavaci_znacka'] : null;
            $aktivni = isset($auto['aktivni']) ? $auto['aktivni'] : 1;
        } else {
            $znacka = method_exists($auto, 'getZnacka') ? $auto->getZnacka() : null;
            $model = method_exists($auto, 'getModel') ? $auto->getModel() : null;
            $poznavaci_znacka = method_exists($auto, 'getPoznavaciZnacka') ? $auto->getPoznavaciZnacka() : null;
            $aktivni = method_exists($auto, 'getAktivni') ? ($auto->getAktivni() ? 1 : 0) : 1;
        }

        try {
            $this->connection->beginTransaction();

            $res = $this->connection->query("SELECT COALESCE(MAX(id), 0) AS maxid FROM auta");
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $nextId = (int)$row['maxid'] + 1;

            $sql->bindValue(":id", $nextId, PDO::PARAM_INT);
            $sql->bindValue(":znacka", $znacka);
            $sql->bindValue(":model", $model);
            $sql->bindValue(":poznavaci_znacka", $poznavaci_znacka);
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
    public function getAll($orderBy = "znacka ASC") {
    $allowed = ["id", "znacka", "model", "poznavaci_znacka", "aktivni"];


    $parts = explode(" ", $orderBy);
    $column = $parts[0];
    $direction = strtoupper($parts[1] ?? "ASC");

    if (!in_array($column, $allowed)) {
        $column = "znacka";
    }

    if (!in_array($direction, ["ASC", "DESC"])) {
        $direction = "ASC";
    }

    $query = "SELECT * FROM auta ORDER BY $column $direction";
    $sql = $this->connection->prepare($query);
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_CLASS, "Auta");
    return $sql->fetchAll(); 
}

public function getById($id) {
    $query = "SELECT * FROM auta WHERE id = :id";
    $sql = $this->connection->prepare($query);
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_CLASS, "Auta");
    return $sql->fetch(); 
}
public function deleteById($id) {
    $query = "DELETE FROM auta WHERE id = :id";
    $sql = $this->connection->prepare($query);
    $sql->bindValue(":id", $id, PDO::PARAM_INT);

    return $sql->execute();
}
public function updateById($id, $auto) {
    $query = "UPDATE auta 
              SET znacka = :znacka,
                  model = :model,
                  poznavaci_znacka = :poznavaci_znacka,
                  aktivni = :aktivni
              WHERE id = :id";

    $sql = $this->connection->prepare($query);

    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->bindValue(":znacka", $auto->getZnacka());
    $sql->bindValue(":model", $auto->getModel());
    $sql->bindValue(":poznavaci_znacka", $auto->getPoznavaciZnacka());
    $sql->bindValue(":aktivni", $auto->getAktivni(), PDO::PARAM_INT);

    return $sql->execute();
}
}

?>