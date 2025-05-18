<?php
require_once("../../model/Bdd.php");
if (!empty($_GET)) {
    $param = $_GET["sortBy"];
    if ($param != "") {
        $sql = "SELECT idFaq AS id, question, reponse FROM Faq INNER JOIN CategorieForum ON CategorieForum.idCategorieForum = Faq.themes WHERE CategorieForum.type = '$param'; ";
    } else {
        $sql = "SELECT idFaq AS id, question, reponse FROM Faq";
    }
    $query = $db->prepare($sql);
    $query->execute();
    $jsonData = $query->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes

    if (empty($jsonData)) {
        echo json_encode(["message" => "La table est vide."]);
    } else {
        header('Content-Type: application/json');
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
} else {
    exit();
}
?>