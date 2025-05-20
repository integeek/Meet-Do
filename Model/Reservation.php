<?php
require_once("Bdd.php");

Class Reservation {
    public static function makeReservation($nbPlace, $idClient, $idEvenement) {
        $db = Bdd::getInstance();
        $sql = "INSERT INTO Reservation (dateReservation, nbPlace, listeAttente, placement, idClient, idEvenement) 
        VALUES (NOW(), :nbPlace, :listeAttente, 0, :idClient, :idEvenement)";
        $query = $db->prepare($sql);
        $query->execute([
            ':nbPlace' => $nbPlace,
            ':listeAttente' => 0,
            ':idClient' => $idClient,
            ':idEvenement' => $idEvenement
        ]);
    }
    
}
?>