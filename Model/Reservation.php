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

    public static function getInfoReservation($idClient) {
        $db = Bdd::getInstance();
        $stmt =  $db->prepare("
                    SELECT Activite.idActivite, Activite.titre, Activite.adresse, Activite.prix, Evenement.dateEvenement, Reservation.nbPlace, Reservation.idReservation
                    FROM Reservation
                    INNER JOIN Evenement ON Reservation.idEvenement = Evenement.idEvenement
                    INNER JOIN Activite ON Evenement.idActivite = Activite.idActivite
                    WHERE Reservation.idClient = :idClient
                ");

                $stmt->execute([':idClient' => $idClient]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cancelReservation($idResa) {
        $db = Bdd::getInstance();
        $stmt = $db->prepare("DELETE FROM Reservation WHERE idReservation = :idResa");
        $stmt->bindParam(':idResa', $idResa);
        return $stmt->execute();
    }
    
}
?>