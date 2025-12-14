<?php
class Database {
    private $host = "localhost";
    private $port = 3306; 
    private $user = "root";
    private $pass = "";
    private $dbname = "fatimah_collection_schema.sql"; 
    public $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname,
            $this->port
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

// Buat variabel global $db
$db = (new Database())->conn;
