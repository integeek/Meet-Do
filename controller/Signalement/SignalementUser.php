<?php
session_start();
require_once("../../Model/Bdd.php");

if(!empty($_POST)){
    if(isset($_POST["raison"]) && !empty($_POST["raison"])){
        $raison = $_POST["raison"];
        $commentaire = $_POST["Commentaire"] ?? null;
        $idClient = $_SESSION['user']['id'];
        $idActivite = isset($_POST['idActivite']) ? (int) $_POST['idActivite'] : null;

        $sql1 = "SELECT idMeeter FROM Activite WHERE idActivite = $idActivite";
        $query1 = $db->prepare($sql1);
        $query1->execute();
        $idSignalerRow = $query1->fetch(PDO::FETCH_ASSOC);
        $idSignaler = $idSignalerRow['idMeeter'] ?? null;

        $sql = "INSERT INTO Signalement (type, enumSignalementUtilisateur, description, dateSignalement, idSignaleur, idSignaler) VALUES ('Client', :raison, :description, NOW(), :idSignaleur, :idSignaler)";
        $query = $db->prepare($sql);
        $query -> bindValue(":raison", $raison);
        $query -> bindValue(":description", $commentaire, PDO::PARAM_STR);
        $query -> bindValue(":idSignaleur", $idClient, PDO::PARAM_INT);
        $query -> bindValue(":idSignaler", $idSignaler, PDO::PARAM_INT);
        $query->execute();
        echo "Le signalement a été envoyé avec succès.";
    } else {
        die("Le formulaire est incomplet.");
    }
}

?>