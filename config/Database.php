<?php
class Database
{
    private $host = 'mysql';
    private $port = '3306';
    private $dbname = 'hellofresh';
    private $user = 'hellofresh';
    private $password = 'hellofresh';
    private $conn;

    // Db connect
    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->user, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
