<?php
require_once("../../model/Bdd.php");
require_once("../../model/Messagerie/MessagerieModel.php");
session_start();

class MessagerieController
{
    private $model;
    public function __construct($db)
    {
        $this->model = new MessagerieModel($db);
    }

    public function getUsers()
    {
        $userId = $_SESSION['user']['id'];
        header('Content-Type: application/json');
        $data = $this->model->getUsers($userId);
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function getMessages()
    {
        $userId = $_SESSION['user']['id'];
        $otherId = $_GET['id'] ?? null;
        header('Content-Type: application/json');
        if ($otherId === null) {
            echo json_encode(["error" => "Paramètre id manquant"]);
            return;
        }
        $data = $this->model->getMessages($userId, $otherId);
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function sendMessage()
    {
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $content = $data["content"];
        $idRecepteur = $data["idRecepteur"];
        $file = isset($data["file"]) && $data["file"] !== "false" ? $data["file"] : null;

        header('Content-Type: application/json');
        if (!$content || !$idRecepteur) {
            echo json_encode(["error" => "Données manquantes"]);
            return;
        }
        $success = $this->model->sendMessage($content, $userId, $idRecepteur, $file);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Message ajouté avec succès."], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["error" => "Erreur lors de l'envoi du message"]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new MessagerieController($db);

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'users') {
        $controller->getUsers();
    } elseif ($_GET['action'] === 'messages') {
        $controller->getMessages();
    } elseif ($_GET['action'] === 'send') {
        $controller->sendMessage();
    } else {
        echo json_encode(["error" => "Action inconnue"]);
    }
} else {
    echo json_encode(["error" => "Aucune action spécifiée"]);
}
