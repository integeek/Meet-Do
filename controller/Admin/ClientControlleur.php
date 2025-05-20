<?php
session_start();
require_once("../../model/Bdd.php");
require_once("../../model/Admin/ClientModel.php");

class ClientController {
    private $model;
    public function __construct($db) {
        $this->model = new ClientModel($db);
    }

    public function getClients() {
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $data = $this->model->getClients($search);
        header('Content-Type: application/json');
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function updateClient() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data["idClient"], $data["nom"], $data["prenom"], $data["role"])) {
            echo json_encode(["success" => false, "message" => "Données manquantes ou invalides."]);
            return;
        }
        $success = $this->model->updateClient($data["idClient"], $data["nom"], $data["prenom"], $data["role"]);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Client mis à jour avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour du client."]);
        }
    }

    public function deleteClient() {
        $idClient = $_GET["id"] ?? null;
        if (!$idClient) {
            echo json_encode(["success" => false, "message" => "ID manquant."]);
            return;
        }
        $success = $this->model->deleteClient($idClient);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Client supprimé avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression du client."]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new ClientController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getClients();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->updateClient();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->deleteClient();
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>