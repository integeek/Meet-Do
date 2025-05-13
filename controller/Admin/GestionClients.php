<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET["search"];
        if ($search != "") {
                $sql = "SELECT nom, prenom, email, role FROM Client WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'OR email LIKE '%$search%'";
        } else {
                $sql = "SELECT nom, prenom, email, role FROM Client";
        }
        $query = $db->prepare($sql);
        $query->execute();
        $jsonData = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($jsonData)) {
                echo json_encode(["message" => "La table est vide."]);
        } else {
                header('Content-Type: application/json');
                echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        }
}
?>
