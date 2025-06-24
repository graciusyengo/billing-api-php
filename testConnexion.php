<?php
require_once './config/database.php';

// On crée un objet de la classe Database
$db = new Database();

// On récupère la connexion à MySQL
$conn = $db->getConnection();

// Test de la connexion
if ($conn) {
    echo "✅ Connexion réussie à la base de données MySQL";
} else {
    echo "❌ Connexion échouée";
}