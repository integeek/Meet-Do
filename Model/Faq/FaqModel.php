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

    public function addQuestion($question, $reponse, $theme) {
        $db = Bdd::getInstance();
        $sql = "INSERT INTO Faq (idFaq, question, reponse, themes) VALUES (NULL, :question, :reponse, :theme)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':question', $question, PDO::PARAM_STR);
        $query->bindParam(':reponse', $reponse, PDO::PARAM_STR);
        $query->bindParam(':theme', $theme, PDO::PARAM_INT);
        return $query->execute();
    }

    public function deleteQuestion($id) {
        Bdd::getInstance();
        $sql = "DELETE FROM Faq WHERE idFaq = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
}
?>