<?php
require_once("../../model/Bdd.php");

if (!empty($_GET)) {
    try {
        $param = $_GET["sortBy"];

        // Requête principale pour récupérer les questions
        $sqlQuestions = "
            SELECT
                SujetForum.idSujetForum AS id,
                SujetForum.dateCreationl AS date,
                SujetForum.titre AS question,
                CONCAT(Client.nom, ' ', Client.prenom) AS userName,
                CategorieForum.type AS theme
            FROM `SujetForum`
            INNER JOIN Client ON SujetForum.idClient = Client.idClient 
            INNER JOIN CategorieForum ON CategorieForum.idCategorieForum = SujetForum.idCategorieForum;
        ";
        $queryQuestions = $db->prepare($sqlQuestions);
        $queryQuestions->execute();
        $questions = $queryQuestions->fetchAll(PDO::FETCH_ASSOC);

        // Parcourir chaque question pour récupérer les réponses associées
        foreach ($questions as &$question) {
            $sqlAnswers = "
                SELECT 
                    CONCAT(Client.nom, ' ', Client.prenom) AS userName,
                    MessageForum.dateEnvoie AS date,
                    MessageForum.message AS answer
                FROM `MessageForum` 
                INNER JOIN Client ON Client.idClient = MessageForum.idRedacteur
                WHERE MessageForum.idSujetForum = :forumId;
            ";
            $queryAnswers = $db->prepare($sqlAnswers);
            $queryAnswers->execute(['forumId' => $question['id']]);
            $answers = $queryAnswers->fetchAll(PDO::FETCH_ASSOC);

            // Ajouter les réponses à la question
            $question['answer'] = $answers;
        }

        // Retourner le JSON final
        header('Content-Type: application/json');
        echo json_encode($questions, JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        // Gestion des erreurs
        echo json_encode(["error" => "Erreur lors de la récupération des données : " . $e->getMessage()]);
    }
} else {
    header("Location: ../../view/page/FAQ.html");
    exit();
}
?>