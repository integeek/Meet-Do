<?php
require_once(__DIR__ . "/../Bdd.php");

class ModifierTablesModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getThemes() {
        // Récupère tous les thèmes Forum et Activité
        $sqlForum = "SELECT type AS themes FROM CategorieForum";
        $queryForum = $this->db->prepare($sqlForum);
        $queryForum->execute();
        $forumThemes = $queryForum->fetchAll(PDO::FETCH_ASSOC);

        $sqlActivite = "SELECT nom AS themes FROM Categorie";
        $queryActivite = $this->db->prepare($sqlActivite);
        $queryActivite->execute();
        $activiteThemes = $queryActivite->fetchAll(PDO::FETCH_ASSOC);

        return [
            "Forum" => $forumThemes,
            "Activite" => $activiteThemes
        ];
    }

    public function addThemeForum($theme) {
        $sql = "INSERT INTO CategorieForum (type) VALUES (:theme)";
        $query = $this->db->prepare($sql);
        return $query->execute(['theme' => $theme]);
    }

    public function addThemeActivite($theme) {
        $sql = "INSERT INTO Categorie (nom) VALUES (:theme)";
        $query = $this->db->prepare($sql);
        return $query->execute(['theme' => $theme]);
    }
}
?>