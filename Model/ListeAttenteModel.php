<?php
require_once(__DIR__ . "/Bdd.php");

class ListeAttenteModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getEvenement($idEvenement) {
        $sql = "SELECT Evenement.dateEvenement, Activite.titre, Activite.tailleGroupe
                FROM Evenement
                INNER JOIN Activite ON Activite.idActivite = Evenement.idActivite
                WHERE Evenement.idEvenement = :idEvenement";
        $query = $this->db->prepare($sql);
        $query->execute(['idEvenement' => $idEvenement]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getListeParticipants($idEvenement) {
        $sql = "SELECT Reservation.nbPlace AS place, Client.email, Client.nom, Client.prenom, Client.idClient, Reservation.idReservation 
                FROM Reservation
                INNER JOIN Client ON Client.idClient = Reservation.idClient
                WHERE Reservation.idEvenement = :idEvenement AND Reservation.listeAttente = 0";
        $query = $this->db->prepare($sql);
        $query->execute(['idEvenement' => $idEvenement]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListeAttente($idEvenement) {
        $sql = "SELECT Reservation.nbPlace AS place, Client.email, Client.nom, Client.prenom, Client.idClient, Reservation.idReservation
                FROM Reservation
                INNER JOIN Client ON Client.idClient = Reservation.idClient
                WHERE Reservation.idEvenement = :idEvenement AND Reservation.listeAttente = 1";
        $query = $this->db->prepare($sql);
        $query->execute(['idEvenement' => $idEvenement]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReservation($idReservation) {
        $sql = "DELETE FROM Reservation WHERE idReservation = :idReservation";
        $query = $this->db->prepare($sql);
        return $query->execute([
            'idReservation' => $idReservation,
        ]);
    }
}
?>