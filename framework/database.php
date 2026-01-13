<?php

class Database {
    private const DSN = "mysql:dbname=autoskola;charset=UTF8;host=localhost";
    private const user = "root";
    private const password = "";
    private static $connection;

    public static function connect() {
        $connection = new PDO(self::DSN, self::user, self::password);
        return $connection;
    }
}

?>