<?php
class Database {
    public static function connect() {
        try {
            $pdo = new PDO("sqlite:".__DIR__."/database.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: ".$e->getMessage());
        }
    }
}
