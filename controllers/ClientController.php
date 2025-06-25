<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleRequest($method, $id = null) {
        $client = new Client($this->db);

        switch ($method) {
            case 'GET':
                if ($id) {
                    $client->id = $id;
                    $data = $client->readOne();
                    sendJson($data ?: ['message' => 'Client non trouvé'], $data ? 200 : 404);
                } else {
                    $stmt = $client->readAll();
                    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    sendJson($clients);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents("php://input"), true);
                if (!$input) return sendJson(['message' => 'Données JSON invalides'], 400);

                $client->nom = $input['nom'] ?? null;
                $client->prenom = $input['prenom'] ?? null;
                $client->telephone = $input['telephone'] ?? null;
                $client->email = $input['email'] ?? null;
                $client->adresse = $input['adresse'] ?? null;

                $success = $client->create();
                sendJson(['success' => $success]);
                break;

            case 'PUT':
                if (!$id) return sendJson(['message' => 'ID requis'], 400);

                $input = json_decode(file_get_contents("php://input"), true);
                if (!$input) return sendJson(['message' => 'Données JSON invalides'], 400);

                $client->id = $id;
                $client->nom = $input['nom'] ?? null;
                $client->prenom = $input['prenom'] ?? null;
                $client->telephone = $input['telephone'] ?? null;
                $client->email = $input['email'] ?? null;
                $client->adresse = $input['adresse'] ?? null;

                $success = $client->update();
                sendJson(['success' => $success]);
                break;

            case 'DELETE':
                if (!$id) return sendJson(['message' => 'ID requis'], 400);
                $client->id = $id;
                $success = $client->delete();
                sendJson(['success' => $success]);
                break;

            default:
                sendJson(['message' => 'Méthode non autorisée'], 405);
        }
    }
}
