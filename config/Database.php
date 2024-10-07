<?php
namespace Config;

use PDO;
use PDOException;

class Database {

    private $host = 'localhost';
    private $db_name = 'test_db';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->exec('set names utf8mb4');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo json_encode(['message' => 'Database Connection Error: ' . $e->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
?>
