<?php
session_start();
require_once("../../model/Bdd.php");
require_once("../../model/Admin/SignalementUtilisateurModel.php");

class SignalementController {
    private $model;
    public function __construct($db) {
        $this->model = new SignalementModel($db);
    }

    public function getSignalements() {
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $data = $this->model->getSignalements($search);
        header('Content-Type: application/json');
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function deleteSignalement() {
        $id = $_GET["id"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant."]);
            return;
        }
        $success = $this->model->deleteSignalement($id);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Signalement supprimé avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression du signalement."]);
        }
    }

    public function blockUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $idClient = $data["idClient"] ?? null;
        if (!$idClient) {
            echo json_encode(["success" => false, "message" => "ID client manquant."]);
            return;
        }
        $success = $this->model->blockUser($idClient);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Utilisateur bloqué et signalements supprimés."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors du blocage ou de la suppression."]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new SignalementController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getSignalements();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->deleteSignalement();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->blockUser();
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>