<?php
class Client {
    private $conn;
    public $id;
    public $nom;
    public $prenom;
    public $telephone;
    public $email;
    public $adresse;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO clients (nom, prenom, telephone, email, adresse)
                  VALUES (:nom, :prenom, :telephone, :email, :adresse)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':telephone' => $this->telephone,
            ':email' => $this->email,
            ':adresse' => $this->adresse
        ]);
    }

    public function readAll() {
        $query = "SELECT * FROM clients";
        return $this->conn->query($query);
    }

    public function readOne() {
        $query = "SELECT * FROM clients WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE clients SET nom = :nom, prenom = :prenom, telephone = :telephone,
                  email = :email, adresse = :adresse WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':telephone' => $this->telephone,
            ':email' => $this->email,
            ':adresse' => $this->adresse,
            ':id' => $this->id
        ]);
    }

    public function delete() {
        $query = "DELETE FROM clients WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $this->id]);
    }
}

