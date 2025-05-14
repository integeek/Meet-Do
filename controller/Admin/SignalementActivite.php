
<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET["search"];
        if ($search != "") {
                $sql = "SELECT Signalement.idSignalement AS 'id', Client.nom, Client.prenom, Signalement.dateSignalement FROM `Signalement` INNER JOIN Client ON Signalement.idSignaler = Client.idClient WHERE Signalement.type = 'Activité' AND nom LIKE '%$search%' OR prenom LIKE '%$search%' OR dateSignalement LIKE '%$search%'";
        } else {
                $sql = "SELECT Signalement.idSignalement AS 'id', Client.nom, Client.prenom, Signalement.dateSignalement FROM `Signalement` INNER JOIN Client ON Signalement.idSignaler = Client.idClient WHERE Signalement.type = 'Activité'";
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