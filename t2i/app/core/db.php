<?php

class DB extends PDO {
    private static $dsn = "mysql:host=localhost;dbname=example_1;charset=utf8";
    private static $username = "admin";
    private static $password = "admin";


    private static $pdo;

    public static function getPdo()
    {
        if (DB::$pdo == null) {
            DB::$pdo = new PDO(DB::$dsn, DB::$username, DB::$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return DB::$pdo;
    }
}
