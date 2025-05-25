<?php
require_once("../../Model/Bdd.php");
require_once("../../Model/Faq/FaqModel.php");

class FaqController {
    private $model;
    public function __construct($db) {
        $this->model = new FaqModel($db);
    }

    public function getThemes() {
        header('Content-Type: application/json');
        $data = $this->model->getThemes();
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }

    public function getQuestions() {
        $theme = isset($_GET['sortBy']) ? $_GET['sortBy'] : null;
        header('Content-Type: application/json');
        $data = $this->model->getQuestions($theme);
        echo json_encode($data ?: ["message" => "La table est vide."], JSON_UNESCAPED_UNICODE);
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new FaqController($db);

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'themes') {
        $controller->getThemes();
    } elseif ($_GET['action'] === 'questions') {
        $controller->getQuestions();
    } else {
        echo json_encode(["error" => "Action inconnue"]);
    }
} else {
    echo json_encode(["error" => "Aucune action spécifiée"]);
}
?>