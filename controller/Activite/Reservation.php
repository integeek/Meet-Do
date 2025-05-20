<?php 
require_once("../../Model/Reservation.php");
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

$idEvenement = Reservation::selectEvenement($date, $heureDebut);

if (!$idEvenement) {
    echo json_encode(["success" => false, "message" => "Créneau introuvable"]);
    exit;
}
Reservation::makeReservation($nbPlace, $idClient, $idEvenement);

echo json_encode(["success" => true]);
exit;
?>
