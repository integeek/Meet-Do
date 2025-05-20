<?php
require_once("Bdd.php");

Class Reservation {
    public static function selectEvenement($date, $heure) {
        $db = Bdd::getInstance();
        $sql = "SELECT idEvenement FROM Evenement WHERE DATE(dateEvenement) = :date AND HOUR(dateEvenement) = :heure";
        $query = $db->prepare(query: $sql);
        $query->bindValue(':date', $date);
        $query->bindValue(':heure', intval(explode(":", $heure)[0]));
        $query->execute();
        return $query->fetchColumn();
    }

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