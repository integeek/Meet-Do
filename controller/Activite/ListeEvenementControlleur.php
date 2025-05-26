<?php
session_start();
require_once("../../Model/Bdd.php");
require_once("../../Model/ListeEvenementModel.php");

class ListeEvenementController {
    private $model;
    public function __construct($db) {
        $this->model = new ListeEvenementModel($db);
    }

    public function getEvenements($idActivite) {
        $evenements = $this->model->getEvenements($idActivite);
        header('Content-Type: application/json');
        echo json_encode(['evenements' => $evenements]);
    }
}

// Routage simple
$db = Bdd::getInstance();
$controller = new ListeEvenementController($db);

$action = $_GET['action'] ?? '';
$idActivite = $_GET['id'] ?? null;

if ($action === 'liste' && $idActivite) {
    $controller->getEvenements($idActivite);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Paramètres manquants ou action inconnue']);
}
?>