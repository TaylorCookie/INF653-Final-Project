<?php
    class Quote {
        //DB Stuff
        private $conn;
        private $table = 'quotes';

        //Post Props
        public $id;
        public $quote;
        public $authorId;
        public $categoryId;
        public $author;
        public $category;
        public $limitNum;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Quotes Default
        public function read($limit) {
            //Create Query
            if ($limit) {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                ORDER BY q.quote ASC
                LIMIT ' . $limit;
            } else {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                ORDER BY q.quote ASC';
            }
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);
           
            //execute query
            $stmt->execute();

            return $stmt;
        }   

        //Get Quotes with only categoryId set
        public function read_categoryId($limit) {
            //Create Query
            if ($limit) {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE c.id = :categoryId
                LIMIT ' . $limit;
            } else {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE c.id = :categoryId';
            }

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            //Bind Data
            $stmt->bindParam(':categoryId', $this->categoryId);
            
            //execute query
            $stmt->execute();

            return $stmt;
        }   

        //Get Quotes with only authorId set
        public function read_authorId($limit) {
             //Create Query
            if ($limit) {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE a.id = :authorId
                LIMIT ' . $limit;
            } else {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE a.id = :authorId';
            }

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));

            //Bind Data
            $stmt->bindParam(':authorId', $this->authorId);
            
            //execute query
            $stmt->execute();

            return $stmt;
        }   

        //Get Quotes with both categoryId and authorId set
        public function read_both($limit) {
             //Create Query
             if ($limit) {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE c.id = :categoryId
                AND a.id = :authorId
                LIMIT ' . $limit;
            } else {
                $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE c.id = :categoryId
                AND a.id = :authorId';
            }

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            //Bind Data
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':authorId', $this->authorId);
            
            //execute query
            $stmt->execute();

            return $stmt;
        }   

        //Get Single Quote
        public function read_single() {
            //Create Query
            $query = 'SELECT q.id, q.quote, q.authorId, q.categoryId, a.author, c.category 
                FROM quotes q 
                LEFT JOIN authors a 
                    ON q.authorId = a.id 
                LEFT JOIN categories c 
                    ON q.categoryId = c.id
                WHERE q.id = ?
                LIMIT 0, 1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id);
            
            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Props
            $this->quote = $row['quote'];
            $this->id = $row['id'];
            $this->authorId = $row['authorId'];
            $this->categoryId = $row['categoryId'];
            $this->author = $row['author'];
            $this->category = $row['category'];

        }

        //Create Quote
        public function create() {
            //Create query
            $query = 'INSERT INTO quotes  
                SET
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId';
               
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            
            //Clean Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            

            //Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Update Quote
        public function update() {
            //Create query
            $query = 'UPDATE quotes  
                SET
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId
                WHERE
                    id = :id';
               
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            
            //Clean Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            $this->id = htmlspecialchars(strip_tags($this->id));
            

            //Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':id', $this->id);

            //Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Delete Post
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