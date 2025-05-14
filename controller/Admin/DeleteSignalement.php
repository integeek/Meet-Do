<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = $_GET["id"];
        $sql = "DELETE FROM Signalement WHERE idSignalement = $id";
        echo $sql;
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
