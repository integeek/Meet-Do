<?php
require_once("../../model/Bdd.php");
if (!empty($_GET)) {
    $param = $_GET["sortBy"];
    $sql = "SELECT idFaq AS id, question, reponse FROM Faq";
    //$sql = "SELECT * FROM Faq WHERE theme = :param";
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
    header("Location: ../../view/page/FAQ.html");
    exit();
}
?>