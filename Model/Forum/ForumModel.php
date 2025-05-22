<?php
require_once(__DIR__ . "/../Bdd.php");

class ForumModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getThemes()
    {
        $sql = "SELECT type AS theme FROM CategorieForum";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getThemeById($theme)
    {
        $sql = "SELECT idCategorieForum  AS id FROM CategorieForum WHERE type = :theme";
        $query = $this->db->prepare($sql);
        $query->execute(['theme' => $theme]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestions($selectBy = null, $search = null)
    {
        $sqlQuestions = "SELECT
                    SujetForum.idSujetForum AS id,
                    SujetForum.dateCreationl AS date,
                    SujetForum.titre AS question,
                    CONCAT(Client.nom, ' ', Client.prenom) AS userName,
                    CategorieForum.type AS theme
                FROM SujetForum
                INNER JOIN Client ON SujetForum.idClient = Client.idClient
                INNER JOIN CategorieForum ON CategorieForum.idCategorieForum = SujetForum.idCategorieForum";

        if ($selectBy != "") {
            $sqlQuestions .= " WHERE CategorieForum.type = '$selectBy'";
        }
        if ($search != "" && $selectBy != "") {
            $sqlQuestions .= " AND SujetForum.titre LIKE '%$search%'";
        } elseif ($search != "") {
            $sqlQuestions .= " WHERE SujetForum.titre LIKE '%$search%'";
        }
        $sqlQuestions .= ";";
        $query = $this->db->prepare($sqlQuestions);
        $query->execute();
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($questions as &$question) {
            $sqlAnswers = "
                SELECT 
                    CONCAT(Client.nom, ' ', Client.prenom) AS userName,
                    MessageForum.dateEnvoie AS date,
                    MessageForum.message AS answer
                FROM MessageForum
                INNER JOIN Client ON Client.idClient = MessageForum.idRedacteur
                WHERE MessageForum.idSujetForum = :forumId
                ORDER BY MessageForum.dateEnvoie ASC
            ";
            $queryAnswers = $this->db->prepare($sqlAnswers);
            $queryAnswers->execute(['forumId' => $question['id']]);
            $answers = $queryAnswers->fetchAll(PDO::FETCH_ASSOC);
            $question['answer'] = $answers;
        }

        return $questions;
    }

    public function addResponse($idMessage, $idUser, $message)
    {
        $sql = "INSERT INTO `MessageForum`(`message`, `dateEnvoie`, `idSujetForum`, `idRedacteur`) 
            VALUES (:message, NOW(), :idMessage, :idUser)";
        $query = $this->db->prepare($sql);
        return $query->execute([
            "message" => $message,
            "idMessage" => $idMessage,
            "idUser" => $idUser
        ]);
    }

    public function addQuestion($idTheme, $idUser, $reponse, $question)
    {
        $sql = "INSERT INTO `SujetForum`(`titre`, `description`, `dateCreationl`, `idClient`, `idCategorieForum`) 
            VALUES (:question, :response, NOW(), :idUser, :idTheme)";
        $query = $this->db->prepare($sql);
        $success = $query->execute([
            "idUser" => $idUser,
            "idTheme" => $idTheme,
            "response" => $reponse,
            "question" => $question
        ]);

        if ($success) {
            $sujetId = $this->db->lastInsertId();

            return $this->addResponse($sujetId, $idUser, $reponse);
        }

        return false;
    }
}
