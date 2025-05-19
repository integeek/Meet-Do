<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $sql = "SELECT type AS 'themes' FROM `CategorieForum`;";
        $query = $db->prepare($sql);
        $query->execute();
        $forumThemes = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT nom AS 'themes' FROM `Categorie`;";
        $query = $db->prepare($sql);
        $query->execute();
        $activiteThemes = $query->fetchAll(PDO::FETCH_ASSOC);


        $result = [
                "Forum" => $forumThemes,
                "Activite" => $activiteThemes
        ];

        header('Content-Type: application/json');
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
