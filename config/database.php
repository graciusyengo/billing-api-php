<?php
class Database {
    private $host = "localhost";
    private $db_name = "telecom_billing";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name;charset=utf8",
                $this->username,
                $this->password
            );

            $this->createClientsTableIfNotExists();
        } catch (PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
        }

        return $this->conn;
    }


    private function createClientsTableIfNotExists() {
        $sql = "
            CREATE TABLE IF NOT EXISTS clients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100),
                telephone VARCHAR(20),
                email VARCHAR(100),
                adresse TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->conn->exec($sql);
    }
}
