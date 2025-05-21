<?php
require_once(__DIR__ . "/../Bdd.php");

class FaqModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getThemes() {
        $sql = "SELECT type as Theme FROM CategorieForum";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestions($theme = null) {
        if ($theme) {
            $sql = "SELECT idFaq AS id, question, reponse FROM Faq 
                    INNER JOIN CategorieForum ON CategorieForum.idCategorieForum = Faq.themes 
                    WHERE CategorieForum.type = :theme";
            $query = $this->db->prepare($sql);
            $query->bindParam(':theme', $theme, PDO::PARAM_STR);
        } else {
            $sql = "SELECT idFaq AS id, question, reponse FROM Faq";
            $query = $this->db->prepare($sql);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>