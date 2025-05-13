<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET["search"];
        if ($search != "") {
                $sql = "SELECT Client.nom, Client.prenom, Meeter.idMeeter, Meeter.dateDemandeMeeter AS 'date' FROM `Meeter`INNER JOIN Client ON Client.idClient = Meeter.idClient WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%' OR dateDemandeMeeter LIKE '%$search%'";
        } else {
                $sql = "SELECT Client.nom, Client.prenom, Meeter.idMeeter, Meeter.dateDemandeMeeter AS 'date' FROM `Meeter`INNER JOIN Client ON Client.idClient = Meeter.idClient;";
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