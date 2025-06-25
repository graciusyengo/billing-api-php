<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ClientController.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupérer l'URI (ex: /api/client.php/5)
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Supprimer /api/client.php de l'URI
$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');
$id = is_numeric($path) ? intval($path) : null;

// Appeler le contrôleur
$controller = new ClientController($db);
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $id);