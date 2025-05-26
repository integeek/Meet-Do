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

    public function addQuestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = isset($_POST['question']) ? $_POST['question'] : null;
            $reponse = isset($_POST['reponse']) ? $_POST['reponse'] : null;
            $theme = isset($_POST['theme']) ? $_POST['theme'] : null;

            if ($question && $reponse && $theme) {
                $result = $this->model->addQuestion($question, $reponse, $theme);
                if ($result) {
                    $_SESSION['success'] = "Question ajoutée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout de la question.";
                }
                header("Location: ../../view/page/FAQ.php");
                exit;
            }
        }
}

public function deleteQuestion() {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = $this->model->deleteQuestion($id);
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Erreur lors de la suppression."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "ID manquant."]);
    }
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
    } elseif ($_GET['action'] === 'addQuestion') {
        $controller->addQuestion();
    } elseif ($_GET['action'] === 'deleteQuestion') {
        $controller->deleteQuestion();
    } else {
        echo json_encode(["error" => "Action inconnue"]);
    }
} else {
    echo json_encode(["error" => "Aucune action spécifiée"]);
}
?>