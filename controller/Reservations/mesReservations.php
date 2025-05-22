<?php
session_start();
require_once("../../model/Reservation.php");

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

$idClient = $_SESSION['user']['id'];
$reservations = Reservation::getInfoReservation($idClient);

?>


