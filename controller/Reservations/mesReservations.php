<?php
session_start();
require_once("../../Model/Reservation.php");

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

$idClient = $_SESSION['user']['id'];
$reservations = Reservation::getInfoReservation($idClient);

?>


