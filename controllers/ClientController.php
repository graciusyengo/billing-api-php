<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../helpers/SendJson.php';

class ClientController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleRequest($method, $action,$id = null) {
        $client = new Client($this->db);

        switch ($action) {

                case 'liste':
                    if ($method !== 'GET') return sendJson(['message' => 'Méthode non autorisée'], 405);
                    $stmt = $client->readAll();
                    sendJson($stmt->fetchAll(PDO::FETCH_ASSOC));
                    break;
    
                case 'detail':
                    if ($method !== 'GET' || !$id) return sendJson(['message' => 'ID requis'], 400);
                    $client->id = $id;
                    $data = $client->readOne();
                    sendJson($data ?: ['message' => 'Client non trouvé'], $data ? 200 : 404);
                    break;

                       case 'ajouter':
                        if ($method !== 'POST') return sendJson(['message' => 'Méthode non autorisée'], 405);
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

                        case 'modifier':
                            if ($method !== 'PUT' || !$id) return sendJson(['message' => 'ID requis'], 400);
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
                            case 'supprimer':
                                if ($method !== 'DELETE' || !$id) return sendJson(['message' => 'ID requis'], 400);
                                $client->id = $id;
                                $success = $client->delete();
                                sendJson(['success' => $success]);
                                break;

            default:
                sendJson(['message' => 'Méthode non autorisée'], 405);
        }
    }
}
