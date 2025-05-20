<?php
require_once(__DIR__ . "/../Bdd.php");

class SignalementActiviteModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getSignalements($search = "") {
        if ($search !== "") {
            $sql = "SELECT Signalement.idSignalement AS id, Signalement.idActivite AS idActivite, Activite.titre, Signalement.enumSignalementActivité AS motif, Signalement.description AS raison, Signalement.dateSignalement
                    FROM Signalement
                    INNER JOIN Activite ON Activite.idActivite = Signalement.idActivite
                    WHERE Signalement.type = 'Activité'
                    AND (Activite.titre LIKE :search OR Signalement.enumSignalementActivité LIKE :search)";
            $query = $this->db->prepare($sql);
            $like = "%$search%";
            $query->bindParam(':search', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT Signalement.idSignalement AS id, Signalement.idActivite AS idActivite, Activite.titre, Signalement.enumSignalementActivité AS motif, Signalement.description AS raison, Signalement.dateSignalement
                    FROM Signalement
                    INNER JOIN Activite ON Activite.idActivite = Signalement.idActivite
                    WHERE Signalement.type = 'Activité'";
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

    public function blockActivite($idActivite) {
        // Bloquer l'activité
        $sql = "UPDATE Activite SET isDisabled = 1 WHERE idActivite = :idActivite";
        $query = $this->db->prepare($sql);
        $query->execute(['idActivite' => $idActivite]);

        // Supprimer les signalements liés à cette activité
        $sql = "DELETE FROM Signalement WHERE idActivite = :idActivite";
        $query = $this->db->prepare($sql);
        return $query->execute(['idActivite' => $idActivite]);
    }
}
?>