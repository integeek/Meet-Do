<?php
require_once("../../model/Bdd.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT type as 'Theme' FROM `CategorieForum`;";
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