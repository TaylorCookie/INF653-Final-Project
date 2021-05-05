<?php

class Database {
    /*
    private static $dsn = 'mysql:host=y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=t1v10q62hhx7ktca';
    */
    
    private static $db;
    private $conn;

    //DB Connect
    public function connect() {
        //stuff from https://devcenter.heroku.com/articles/jawsdb#using-jawsdb-with-php
        $url = getenv('mysql://fg50z9bjvy50qzn5:v94dvu4svni96f58@y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/t1v10q62hhx7ktca');
        $dbparts = parse_url($url);

        $hostname = 'y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        $username = 'fg50z9bjvy50qzn5';
        $password = 'v94dvu4svni96f58';
        $database = 't1v10q62hhx7ktca';

        /*
        $hostname = $dbparts['host'];
        $username = $dbparts['user'];
        $password = $dbparts['pass'];
        $database = ltrim($dbparts['path'],'/');
        */

        //set dsn variable
        $dsn = "mysql:host={$hostname};dbname={$database}";

        $this->conn = null;

        
        if (!isset(self::$db)) {
            try {
                $this->conn = new PDO($dsn, $username, $password);
                self::$db = new PDO($dsn, $username, $password);
                
                
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


    