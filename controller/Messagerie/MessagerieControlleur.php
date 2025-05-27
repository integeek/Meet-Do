<?php
require_once("../../Model/Bdd.php");
require_once("../../Model/Messagerie/MessagerieModel.php");
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
        $content = $_POST["content"];
        $idRecepteur = $_POST["idRecepteur"];
        $file = false;

        if (isset($_FILES["file"])) {
            $uploadDir = '../../view/assets/uploads/messagerie/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $uniqueName = time() . '_' . uniqid() . '.' . $extension;
            $targetFile = $uploadDir . $uniqueName;
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            if (!in_array($extension, $allowedTypes)) {
                echo json_encode(["error" => "Type de fichier non autorisé"]);
                exit;
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                $relativePath = 'view/assets/uploads/messagerie/' . $uniqueName;
                $content = $relativePath;
                $file = true;
            } else {
                echo json_encode(["error" => "Erreur lors de l'upload"]);
            }
        }


        if (!$content || !$idRecepteur) {
            echo json_encode(["error" => "Données manquantes"]);
            return;
        }

        $success = $this->model->sendMessage($content, $userId, $idRecepteur, $file);

        echo $file;
        echo $content;

        if ($success) {
            echo json_encode(["success" => true, "message" => "Message ajouté avec succès."], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["error" => "Erreur lors de l'envoi du message"]);
        }
    }

    public function contact()
    {
        $userId = $_SESSION['user']['id'];
        $meeterId = $_GET['id'] ?? null;
        $activityName = $_GET['activityName'] ?? null;

        header('Content-Type: application/json');

        $success = $this->model->contact($userId, $meeterId, $activityName);
        if ($success) {
            echo json_encode(["success" => true, "redirect" => true]);
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->contact();
} else {
    echo json_encode(["error" => "Aucune action spécifiée"]);
}
