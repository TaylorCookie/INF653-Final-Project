<?php

class Database {
    private static $dsn = 'mysql:host=y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=t1v10q62hhx7ktca';
    private static $host = 'y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
    private static $username = 'fg50z9bjvy50qzn5';
    private static $password = 'v94dvu4svni96f58';
    private static $dbname = 'poop';//'t1v10q62hhx7ktca';
    private static $db;
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;

        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password
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


    