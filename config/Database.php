<?php

class Database {
    private static $dsn = 'mysql:host=localhost;dbname=quotesdb';
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = 'password';
    private static $dbname = 'quotesdb';
    private static $db;
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;

        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, //self::$password
                );
            } catch (PDOException $e) {
                $error_message = 'Database Error: ';
                $error_message .= $e->getMessage();
                echo $error_message;
                exit();
            }
        }
        return self::$db;
    }

}


    