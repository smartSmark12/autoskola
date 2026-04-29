<?php

class Database {
    private static $connection;

    private static function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception(".env file not found at {$path}");
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, "\"'");
            $_ENV[$key] = $value;
        }
    }

    public static function connect() {
        if (self::$connection) {
            return self::$connection;
        }

        self::loadEnv(__DIR__ . '/../.env');

        $dsn = sprintf(
            "mysql:dbname=%s;charset=%s;host=%s",
            $_ENV['DB_NAME'],
            $_ENV['DB_CHARSET'],
            $_ENV['DB_HOST']
        );

        self::$connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        return self::$connection;
    }
}

?>
