<?php
    class Author {
        //DB Stuff
        private $conn;
        private $table = 'authors';

        //Props
        public $id;
        public $author;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get authors
        public function read() {
            //Create query
            $query = 'SELECT
                id,
                author
            FROM
                ' . $this->table;

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;

        }

        //Get Single Author
        public function read_single() {
            //Create Query
            $query = 'SELECT id, author
                FROM authors
                WHERE id = ?
                LIMIT 0, 1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id);
            
            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Props
            $this->id = $row['id'];
            $this->author = $row['author'];
        }

        //Create Author
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . $this->table . '  
                SET
                    author = :author';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->author = htmlspecialchars(strip_tags($this->author));          

            //Bind Data
            $stmt->bindParam(':author', $this->author);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Update Author
        public function update() {
            //Create query
            $query = 'UPDATE ' . $this->table . '  
                SET
                    author = :author
                WHERE
                    id = :id';
               
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));
            

            //Bind Data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Delete Author
        public function delete() {
            //Create query
            $query = 'DELETE FROM ' . $this->table . '
                WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }