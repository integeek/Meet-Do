<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET["search"];
        if ($search != "") {
                $sql = "SELECT FormulaireContact.idFormulaireContact AS 'id', nom, prenom, email, FormulaireContact.sujet, FormulaireContact.message, FormulaireContact.dateEnvoie FROM `FormulaireContact` WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%' OR email LIKE '%$search%' OR sujet LIKE '%$search%' OR message LIKE '%$search%';";
        } else {
                $sql = "SELECT FormulaireContact.idFormulaireContact AS 'id', nom, prenom, email, FormulaireContact.sujet, FormulaireContact.message, FormulaireContact.dateEnvoie FROM `FormulaireContact`;";
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