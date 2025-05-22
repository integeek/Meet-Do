<?php
require_once("../../model/Bdd.php");
require_once("../../model/Forum/ForumModel.php");
session_start();

class ForumController
{
    private $model;
    public function __construct($db)
    {
        $this->model = new ForumModel($db);
    }

    public function getThemes()
    {
        header('Content-Type: application/json');
        $data = $this->model->getThemes();
        echo json_encode($data ?: ["message" => "Aucun thème trouvé."], JSON_UNESCAPED_UNICODE);
    }

    public function getQuestions()
    {
        $selectBy = isset($_GET['selectBy']) ? $_GET['selectBy'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        header('Content-Type: application/json');
        $data = $this->model->getQuestions($selectBy, $search);
        echo json_encode($data ?: ["message" => "Aucune question trouvée."], JSON_UNESCAPED_UNICODE);
    }

    public function addResponse()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $idMessage = $data["idMessage"] ?? null;
        $idUser = $data["idUser"] ?? null;
        $message = $data["message"] ?? null;

        header('Content-Type: application/json');
        if (!$idMessage || !$idUser || !$message) {
            echo json_encode(["error" => "Données manquantes"]);
            return;
        }

        $success = $this->model->addResponse($idMessage, $idUser, $message);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Message ajouté avec succès."], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["error" => "Erreur lors de l'ajout du message"]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new ForumController($db);

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'themes') {
        $controller->getThemes();
    } elseif ($_GET['action'] === 'questions') {
        $controller->getQuestions();
    } elseif ($_GET['action'] === 'addResponse') {
        $controller->addResponse();
    } else {
        echo json_encode(["error" => "Action inconnue"]);
    }
} else {
    echo json_encode(["error" => "Aucune action spécifiée"]);
}
