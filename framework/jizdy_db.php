<?php
include_once __DIR__ . "/database.php";

class JizdyDatabase extends Database {
    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertJizda($jizda) {
        $query = "INSERT INTO jizdy (id, id_studenta, id_instruktora, id_auta, zacatek, konec, stav)
                  VALUES (NULL, :id_studenta, :id_instruktora, :id_auta, :zacatek, :konec, :stav)";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id_studenta",    $jizda->getIdStudenta(),    PDO::PARAM_INT);
        $sql->bindValue(":id_instruktora", $jizda->getIdInstruktora(), PDO::PARAM_INT);
        $sql->bindValue(":id_auta",        $jizda->getIdAuta(),        PDO::PARAM_INT);
        $sql->bindValue(":zacatek",        $jizda->getZacatek());
        $sql->bindValue(":konec",          $jizda->getKonec());
        $sql->bindValue(":stav",           $jizda->getStav());

        if ($sql->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }

    private static $allowedSort = [
        "id"                  => "j.id",
        "zacatek"             => "j.zacatek",
        "konec"               => "j.konec",
        "stav"                => "j.stav",
        "student_prijmeni"    => "s.prijmeni",
        "student_jmeno"       => "s.jmeno",
        "instruktor_prijmeni" => "i.prijmeni",
        "instruktor_jmeno"    => "i.jmeno",
        "znacka"              => "a.znacka",
        "model"               => "a.model",
    ];

    private function selectWithJoin() {
        return "SELECT j.id, j.id_studenta, j.id_instruktora, j.id_auta,
                       j.zacatek, j.konec, j.stav,
                       s.jmeno AS student_jmeno, s.prijmeni AS student_prijmeni,
                       i.jmeno AS instruktor_jmeno, i.prijmeni AS instruktor_prijmeni,
                       a.znacka, a.model, a.poznavaci_znacka
                FROM jizdy j
                LEFT JOIN studenti s    ON j.id_studenta = s.id
                LEFT JOIN instruktori i ON j.id_instruktora = i.id
                LEFT JOIN auta a        ON j.id_auta = a.id";
    }

    public function getAll($orderBy = "zacatek DESC") {
        $parts = explode(" ", $orderBy);
        $col = $parts[0];
        $dir = strtoupper($parts[1] ?? "DESC");

        $sortColumn = self::$allowedSort[$col] ?? "j.zacatek";
        if (!in_array($dir, ["ASC", "DESC"], true)) {
            $dir = "DESC";
        }

        $query = $this->selectWithJoin() . " ORDER BY $sortColumn $dir";
        $sql = $this->connection->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Jizdy");
        return $sql->fetchAll();
    }

    public function getById($id) {
        $query = $this->selectWithJoin() . " WHERE j.id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Jizdy");
        $result = $sql->fetch();
        return $result === false ? null : $result;
    }

    public function update($jizda) {
        $query = "UPDATE jizdy
                  SET id_studenta    = :id_studenta,
                      id_instruktora = :id_instruktora,
                      id_auta        = :id_auta,
                      zacatek        = :zacatek,
                      konec          = :konec,
                      stav           = :stav
                  WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id",             $jizda->getId(),            PDO::PARAM_INT);
        $sql->bindValue(":id_studenta",    $jizda->getIdStudenta(),    PDO::PARAM_INT);
        $sql->bindValue(":id_instruktora", $jizda->getIdInstruktora(), PDO::PARAM_INT);
        $sql->bindValue(":id_auta",        $jizda->getIdAuta(),        PDO::PARAM_INT);
        $sql->bindValue(":zacatek",        $jizda->getZacatek());
        $sql->bindValue(":konec",          $jizda->getKonec());
        $sql->bindValue(":stav",           $jizda->getStav());
        return $sql->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM jizdy WHERE id = :id";
        $sql = $this->connection->prepare($query);
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }

    public function getStudentiForSelect() {
        $sql = $this->connection->query(
            "SELECT id, jmeno, prijmeni FROM studenti ORDER BY prijmeni, jmeno"
        );
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInstruktoriForSelect() {
        $sql = $this->connection->query(
            "SELECT id, jmeno, prijmeni FROM instruktori ORDER BY prijmeni, jmeno"
        );
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAutaForSelect() {
        $sql = $this->connection->query(
            "SELECT id, znacka, model, poznavaci_znacka FROM auta ORDER BY znacka, model"
        );
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
