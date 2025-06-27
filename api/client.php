<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ClientController.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupérer l'URI (ex: /api/client.php/5)
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');
$segments = explode('/', $path);


$action = $segments[0] ?? null; // client.php/ajouter
$id = $segments[1] ?? null;

$method = $_SERVER['REQUEST_METHOD'];



$controller = new ClientController($db);
$controller->handleRequest($method, $action, $id)


?>