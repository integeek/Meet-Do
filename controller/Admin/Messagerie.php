<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET["search"];
        if ($search != "") {
                $sql = "SELECT Client.nom, Client.prenom, Client.email, FormulaireContact.sujet, FormulaireContact.message, FormulaireContact.dateEnvoie FROM `FormulaireContact` INNER JOIN Client ON FormulaireContact.idClient = Client.idClient WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'OR email LIKE '%$search%' OR sujet LIKE '%$search%' OR message LIKE '%$search%'";
        } else {
                $sql = "SELECT Client.nom, Client.prenom, Client.email, FormulaireContact.sujet, FormulaireContact.message, FormulaireContact.dateEnvoie FROM `FormulaireContact` INNER JOIN Client ON FormulaireContact.idClient = Client.idClient";
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