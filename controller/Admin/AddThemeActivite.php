<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $themes = $data["themes"];

    $sql = "INSERT INTO `Categorie` (`nom`) VALUES (:themes);";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "themes" => $themes
        ]
    );
}
?>