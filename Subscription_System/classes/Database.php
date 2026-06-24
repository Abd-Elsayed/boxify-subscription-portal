<?php

class Database {
    private $host = "localhost";
    private $db_name = "subscription_db";
    private $username = "root";              
    private $password = "";                  
    public $conn = null;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
           
            die("Connection error: " . $exception->getMessage());
        }
    }

    public function query($sql, $params = []) {
       
        if ($this->conn === null) {
            die("Database connection was never established.");
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getConnection() {
    return $this->conn;
}

public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }

}