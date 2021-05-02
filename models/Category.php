<?php
    class Category {
        //DB Stuff
        private $conn;
        private $table = 'categories';

        //Props
        public $id;
        public $category;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get categories
        public function read() {
            //Create query
            $query = 'SELECT
                id,
                category
            FROM
                ' . $this->table;

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;

        }

        //Get Single Category
        public function read_single() {
            //Create Query
            $query = 'SELECT id, category
                FROM categories
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
            $this->category = $row['category'];
        }

        //Create Category
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . $this->table . '  
                SET
                    category = :category';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));          

            //Bind Data
            $stmt->bindParam(':category', $this->category);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Update Category
        public function update() {
            //Create query
            $query = 'UPDATE ' . $this->table . '  
                SET
                    category = :category
                WHERE
                    id = :id';
               
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));
            

            //Bind Data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Delete Category
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