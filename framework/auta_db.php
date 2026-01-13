<?php

include_once "database.php";

class AutaDatabase extends Database {
    function __construct() {
        $this->connection = $this->connect();
    }

    public function insertAuto($auto) {
        $query = "insert into auta (id,znacka,model,poznavaci_znacka,aktivni) values (NULL,:znacka,:model,:poznavaci_znacka,:aktivni)";
        
        $sql = $this->connection->prepare($query);

        $sql->bindParam(":znacka", $auto->znacka);
        $sql->bindParam(":model", $auto->model);
        $sql->bindParam(":poznavaci_znacka", $auto->poznavaci_znacka);
        $sql->bindParam(":aktivni", $auto->aktivni);

        if($sql->execute()){return $this->connection->lastInsertId();}
        else {return false;}
    }
}

?>