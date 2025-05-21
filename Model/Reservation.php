<?php
require_once("Bdd.php");

Class Reservation {

    public static function getPlacement($idEvenement) {
        $db = Bdd::getInstance();
        $sql = "SELECT COALESCE(MAX(placement), 0) as lastPlacement 
                FROM Reservation 
                WHERE idEvenement = :idEvenement";
        $query = $db->prepare($sql);
        $query->execute([':idEvenement' => $idEvenement]);
        return (int) $query->fetchColumn() + 1;
    }
    public static function makeReservation($nbPlace, $idClient, $idEvenement, $listeAttente = 0) {
        $db = Bdd::getInstance();
        $placement = self::getPlacement($idEvenement); // Appel de la fonction
        $sql = "INSERT INTO Reservation (dateReservation, nbPlace, listeAttente, placement, idClient, idEvenement) 
        VALUES (NOW(), :nbPlace, :listeAttente, :placement, :idClient, :idEvenement)";
        $query = $db->prepare($sql);
        $query->execute([
            ':nbPlace' => $nbPlace,
            ':listeAttente' => $listeAttente,
            'placement' => $placement,
            ':idClient' => $idClient,
            ':idEvenement' => $idEvenement
        ]);
    }
    
}
?>