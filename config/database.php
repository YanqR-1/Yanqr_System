<!-- Kini ang file para sa database connection gamit ang MySQLi extension. 
Nag define siya og Database class nga adunay mga properties para sa host, 
database name, username, password, ug connection object. Ang connect method
mag establish og connection sa database ug mag set sa character set sa utf8mb4 
para ma support ang emojis ug special characters. -->
<?php
class Database {
    private $host = "localhost";
    private $db_name = "yanqr_social";
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