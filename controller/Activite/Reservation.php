<?php 
require_once("../../Model/Reservation.php");
require_once("../../Model/Evenement.php");
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$idClient = $_SESSION['user']['id'] ?? null;

if (!$idClient || !isset($data['date'], $data['heure'], $data['nbPlace'])) {
    echo json_encode(["success" => false, "message" => "Données manquantes ou utilisateur non connecté"]);
    exit;
}

$date = $data["date"];
$heure = $data["heure"];
$nbPlace = intval($data["nbPlace"]);

list($heureDebut, ) = explode("-", $heure);

$idEvenement = Evenement::selectEvenement($date, $heureDebut);

if (!$idEvenement) {
    echo json_encode(["success" => false, "message" => "Créneau introuvable"]);
    exit;
}
Reservation::makeReservation($nbPlace, $idClient, $idEvenement);
$result = Evenement::updatePlacePrise($idEvenement, $nbPlace);
if (!$result) {
    error_log("Erreur lors de la mise à jour placePrise pour l'événement $idEvenement");
}


echo json_encode(["success" => true]);
exit;
?>
