<?php
require_once(__DIR__ . "/Bdd.php");

class ListeEvenementModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getEvenements($idActivite) {
        $sql = "SELECT Evenement.idEvenement, Evenement.dateEvenement, Activite.titre, Evenement.idEvenement
                FROM Evenement
                INNER JOIN Activite ON Activite.idActivite = Evenement.idActivite
                WHERE Evenement.idActivite = :idActivite
                ORDER BY Evenement.dateEvenement ASC";
        $query = $this->db->prepare($sql);
        $query->execute(['idActivite' => $idActivite]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>