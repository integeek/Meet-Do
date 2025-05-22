<?php
require_once(__DIR__ . "/../Bdd.php");

class TableauBordModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getNombreClient() {
        $sql = "SELECT COUNT(*) AS 'number' FROM `Client`;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNombreActivite() {
        $sql = "SELECT COUNT(*) AS 'number' FROM `Activite` WHERE DAY(Activite.dateCreation) = DAY(NOW());";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNombreActiviteTheme() {
        $sql = "SELECT Categorie.nom AS 'activity', COUNT(*) AS 'number' FROM Activite INNER JOIN Categorie ON Categorie.idCategorie = Activite.theme GROUP BY Categorie.nom;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNombreActiviteParMois() {
        $sql = "
            SELECT    
                SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'janvier',
                SUM(CASE MONTH(dateCreation) WHEN 2 THEN 1 ELSE 0 END) AS 'fevrier',
                SUM(CASE MONTH(dateCreation) WHEN 3 THEN 1 ELSE 0 END) AS 'mars',
                SUM(CASE MONTH(dateCreation) WHEN 4 THEN 1 ELSE 0 END) AS 'avril',
                SUM(CASE MONTH(dateCreation) WHEN 5 THEN 1 ELSE 0 END) AS 'mai',
                SUM(CASE MONTH(dateCreation) WHEN 6 THEN 1 ELSE 0 END) AS 'juin',
                SUM(CASE MONTH(dateCreation) WHEN 7 THEN 1 ELSE 0 END) AS 'juillet',
                SUM(CASE MONTH(dateCreation) WHEN 8 THEN 1 ELSE 0 END) AS 'aout',
                SUM(CASE MONTH(dateCreation) WHEN 9 THEN 1 ELSE 0 END) AS 'septembre',
                SUM(CASE MONTH(dateCreation) WHEN 10 THEN 1 ELSE 0 END) AS 'octobre',
                SUM(CASE MONTH(dateCreation) WHEN 11 THEN 1 ELSE 0 END) AS 'novembre',
                SUM(CASE MONTH(dateCreation) WHEN 12 THEN 1 ELSE 0 END) AS 'decembre'
            FROM Activite;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>