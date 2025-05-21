<?php
require_once(__DIR__ . "/../Bdd.php");

class SignalementModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getSignalements($search = "") {
        if ($search !== "") {
            $sql = "SELECT Signalement.idSignalement AS id, Client.idClient, Client.nom, Client.prenom, Signalement.enumSignalementUtilisateur AS motif, Signalement.dateSignalement, Signalement.description AS raison
                    FROM Signalement
                    INNER JOIN Client ON Signalement.idSignaler = Client.idClient
                    WHERE Signalement.type = 'Client'
                    AND (Client.nom LIKE :search OR Client.prenom LIKE :search OR Signalement.dateSignalement LIKE :search)";
            $query = $this->db->prepare($sql);
            $like = "%$search%";
            $query->bindParam(':search', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT Signalement.idSignalement AS id, Client.idClient, Client.nom, Client.prenom, Signalement.enumSignalementUtilisateur AS motif, Signalement.dateSignalement, Signalement.description AS raison
                    FROM Signalement
                    INNER JOIN Client ON Signalement.idSignaler = Client.idClient
                    WHERE Signalement.type = 'Client'";
            $query = $this->db->prepare($sql);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteSignalement($idSignalement) {
        $sql = "DELETE FROM Signalement WHERE idSignalement = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id' => $idSignalement]);
    }

    public function blockUser($idClient) {

        $sql = "UPDATE Client SET isBloqued = 1 WHERE idClient = :idClient";
        $query = $this->db->prepare($sql);
        $query->execute(['idClient' => $idClient]);

        $sql = "DELETE FROM Signalement WHERE idSignaler = :idClient";
        $query = $this->db->prepare($sql);
        return $query->execute(['idClient' => $idClient]);
    }
}
?>