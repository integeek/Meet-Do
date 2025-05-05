<?php
require_once("../../model/Bdd.php");

if (!empty($_GET)) {
    try {
        $param = $_GET["sortBy"];

        // Requête principale pour récupérer les questions
        $sqlQuestions = "
            SELECT
                sujetforum.idSujetForum AS id,
                sujetforum.dateCreationl AS date,
                sujetforum.titre AS question,
                CONCAT(client.nom, ' ', client.prenom) AS userName,
                categorieforum.type AS theme
            FROM `sujetforum`
            INNER JOIN client ON sujetforum.idClient = client.idClient 
            INNER JOIN categorieforum ON categorieforum.idCategorieForum = sujetforum.idCategorieForum;
        ";
        $queryQuestions = $db->prepare($sqlQuestions);
        $queryQuestions->execute();
        $questions = $queryQuestions->fetchAll(PDO::FETCH_ASSOC);

        // Parcourir chaque question pour récupérer les réponses associées
        foreach ($questions as &$question) {
            $sqlAnswers = "
                SELECT 
                    CONCAT(client.nom, ' ', client.prenom) AS userName,
                    messageforum.dateEnvoie AS date,
                    messageforum.message AS answer
                FROM `messageforum` 
                INNER JOIN client ON client.idClient = messageforum.idRedacteur
                WHERE messageforum.idSujetForum = :forumId;
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