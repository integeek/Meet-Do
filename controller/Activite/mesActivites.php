<?php

session_start();

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

require_once("../../model/Bdd.php");

$idClient = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

if ($role !== 'Meeter' && $role !== 'Administrateur') {
    $_SESSION['error'] = "Vous n'avez pas accès à cette page.";
    header("Location: ../../view/Page/Devenir-meeter.php");
    exit;
}

$sql = "SELECT Activite.titre, Activite.adresse, Activite.prix, Activite.idMeeter, Evenement.dateEvenement, Reservation.nbPlace, Reservation.idReservation
        FROM Reservation
        INNER JOIN Evenement ON Reservation.idEvenement = Evenement.idEvenement
        INNER JOIN Activite ON Evenement.idActivite = Activite.idActivite
        WHERE Activite.idMeeter = :idClient";

$stmt = $db->prepare($sql);
$stmt->execute([':idClient' => $idClient]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);




?>