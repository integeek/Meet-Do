<?php
session_start();
require_once("../../model/Bdd.php");
require_once("../../model/Admin/MessagerieAdminModel.php");

class MessagerieAdminController {
    private $model;
    public function __construct($db) {
        $this->model = new MessagerieAdminModel($db);
    }

    public function getMessages() {
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $data = $this->model->getMessages($search);
        header('Content-Type: application/json');
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function deleteMessage() {
        $id = $_GET["id"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant."]);
            return;
        }
        $success = $this->model->deleteMessage($id);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Message supprimé avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression du message."]);
        }
    }

    public function sendResponse() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        $messageReponse = $data['message'] ?? null;
        $userName = $data['userName'] ?? null;
        $email = $data['email'] ?? null;
        $sujet = $data['sujet'] ?? null;

        if (!$id || !$messageReponse || !$userName || !$email || !$sujet) {
            echo json_encode(["success" => false, "message" => "Données manquantes."]);
            return;
        }

        $success = $this->model->sendResponse($id, $messageReponse, $userName, $email, $sujet);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Réponse envoyée et message supprimé."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi ou de la suppression."]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new MessagerieAdminController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getMessages();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->deleteMessage();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->sendResponse();
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>