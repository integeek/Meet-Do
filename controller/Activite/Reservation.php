<?php 
require_once("../../model/Bdd.php");
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

$sql = "SELECT idEvenement FROM Evenement WHERE DATE(dateEvenement) = :date AND HOUR(dateEvenement) = :heure";
$query = $db->prepare($sql);
list($heureDebut, ) = explode("-", $heure);
$query->bindValue(':date', $date);
$query->bindValue(':heure', intval(explode(":", $heureDebut)[0]));
$query->execute();
$idEvenement = $query->fetchColumn();

if (!$idEvenement) {
    echo json_encode(["success" => false, "message" => "Créneau introuvable"]);
    exit;
}

$sql = "INSERT INTO Reservation (dateReservation, nbPlace, listeAttente, placement, idClient, idEvenement) 
        VALUES (NOW(), :nbPlace, :listeAttente, 0, :idClient, :idEvenement)";
$query = $db->prepare($sql);
$query->execute([
    ':nbPlace' => $nbPlace,
    ':listeAttente' => 0,
    ':idClient' => $idClient,
    ':idEvenement' => $idEvenement
]);

echo json_encode(["success" => true]);
exit;
?>
