<?php
session_start();
require_once("../../model/Bdd.php");

if(!empty($_POST)){
    if(isset($_POST["raison"]) && !empty($_POST["raison"])){
        $raison = $_POST["raison"];
        $commentaire = $_POST["Commentaire"] ?? null;
        $idClient = $_SESSION['user']['id'];
        $idActivite = isset($_POST['idActivite']) ? (int) $_POST['idActivite'] : null;
        $sql = "INSERT INTO Signalement (type, enumSignalementActivité, description, dateSignalement, idSignaleur, idActivite) VALUES ('Activité', :raison, :description, NOW(), :idSignaleur, :idActivite)";
        $query = $db->prepare($sql);
        $query -> bindValue(":raison", $raison);
        $query -> bindValue(":description", $commentaire, PDO::PARAM_STR);
        $query -> bindValue(":idSignaleur", $idClient, PDO::PARAM_INT);
        $query -> bindValue(":idActivite", $idActivite, PDO::PARAM_INT);
        $query->execute();
        echo "Le signalement a été envoyé avec succès.";
    } else {
        die("Le formulaire est incomplet.");
    }
}

?>