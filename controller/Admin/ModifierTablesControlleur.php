<?php
session_start();
require_once("../../model/Bdd.php");
require_once("../../model/Admin/ModifierTablesModel.php");

class ModifierTablesController {
    private $model;
    public function __construct($db) {
        $this->model = new ModifierTablesModel($db);
    }

    public function getThemes() {
        $data = $this->model->getThemes();
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function addThemeForum() {
        $data = json_decode(file_get_contents('php://input'), true);
        $theme = $data["themes"] ?? null;
        if (!$theme) {
            echo json_encode(["success" => false, "message" => "Thème manquant."]);
            return;
        }
        $success = $this->model->addThemeForum($theme);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Thème forum ajouté."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout."]);
        }
    }

    public function addThemeActivite() {
        $data = json_decode(file_get_contents('php://input'), true);
        $theme = $data["themes"] ?? null;
        if (!$theme) {
            echo json_encode(["success" => false, "message" => "Thème manquant."]);
            return;
        }
        $success = $this->model->addThemeActivite($theme);
        if ($success) {
            echo json_encode(["success" => true, "message" => "Thème activité ajouté."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout."]);
        }
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new ModifierTablesController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getThemes();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On distingue l'ajout forum/activité par un paramètre action dans l'URL
    if (isset($_GET['type']) && $_GET['type'] === 'forum') {
        $controller->addThemeForum();
    } elseif (isset($_GET['type']) && $_GET['type'] === 'activite') {
        $controller->addThemeActivite();
    } else {
        echo json_encode(["error" => "Type d'ajout non spécifié"]);
    }
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>