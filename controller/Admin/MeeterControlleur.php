<?php
session_start();
require_once("../../model/Bdd.php");
require_once("../../model/Admin/MeeterModel.php");

class MeeterController {
    private $model;
    public function __construct($db) {
        $this->model = new MeeterModel($db);
    }

    public function getDemandes() {
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $data = $this->model->getDemandes($search);
        header('Content-Type: application/json');
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function refuseMeeter() {
        $data = json_decode(file_get_contents('php://input'), true);
        $idMeeter = $data["idMeeter"] ?? null;
        if (!$idMeeter) {
            echo json_encode(["success" => false, "message" => "ID Meeter manquant."]);
            return;
        }
        $success = $this->model->refuseMeeter($idMeeter);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Demande de Meeter rejetée."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression."]);
        }
    }

    public function acceptMeeter() {
        $data = json_decode(file_get_contents('php://input'), true);
        $idClient = $data["idClient"] ?? null;
        $idMeeter = $data["idMeeter"] ?? null;
        $telephone = $data["telephone"] ?? null;
        $adresse = $data["adresse"] ?? null;
        $description = $data["description"] ?? null;

        if (!$idClient || !$idMeeter || !$telephone || !$adresse || !$description) {
            echo json_encode(["success" => false, "message" => "Données manquantes."]);
            return;
        }
        $success = $this->model->acceptMeeter($idClient, $idMeeter, $telephone, $adresse, $description);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Nouveau Meeter accepté."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'acceptation."]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new MeeterController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getDemandes();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $controller->refuseMeeter();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->acceptMeeter();
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>