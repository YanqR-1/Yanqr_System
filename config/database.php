<?php
class Database {
    private $host = "localhost";
    private $db_name = "yanqr_system";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8mb4");
        } catch(Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>