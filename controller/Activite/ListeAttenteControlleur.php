<?php
session_start();
require_once("../../Model/Bdd.php");
require_once("../../Model/ListeAttenteModel.php");

class ListeAttenteController {
    private $model;
    public function __construct($db) {
        $this->model = new ListeAttenteModel($db);
    }

    public function getEvenement($idEvenement) {
        $evenement = $this->model->getEvenement($idEvenement);
        header('Content-Type: application/json');
        echo json_encode($evenement);
    }

    public function getListe($idEvenement) {
        $participants = $this->model->getListeParticipants($idEvenement);
        $attente = $this->model->getListeAttente($idEvenement);
        header('Content-Type: application/json');
        echo json_encode([
            'participants' => $participants,
            'attente' => $attente
        ]);
    }

    public function deleteReservation($idReservation) {
        $success = $this->model->deleteReservation($idReservation);
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => "Erreur lors de la suppression"]);
        }
    }
}

// Routage simple
$db = Bdd::getInstance();
$controller = new ListeAttenteController($db);

$action = $_GET['action'] ?? '';
$idEvenement = $_GET['id'] ?? null;

if ($action === 'event' && $idEvenement) {
    $controller->getEvenement($idEvenement);
} elseif ($action === 'liste' && $idEvenement) {
    $controller->getListe($idEvenement);
} elseif ($action === 'delete' && isset($_GET['idReservation'])) {
    $controller->deleteReservation($_GET['idReservation']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Paramètres manquants ou action inconnue']);
}
?>