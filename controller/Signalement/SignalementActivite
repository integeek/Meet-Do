<?php
session_start();
require_once("../../model/Bdd.php");

if(!empty($_POST)){
    if(isset($_POST["raison"]) && !empty($_POST["raison"])){
        $raison = $_POST["raison"];
        $commentaire = $_POST["Commentaire"] ?? null;
        $idClient = $_SESSION['user']['id'];
        $sql = "INSERT INTO Signalement (type, enumSignalementUtilisateur, description, dateSignalement, idSignaleur, idSignaler) VALUES ('Client', :raison, :description, NOW(), :idSignaleur, :idSignaler)";
        $query = $db->prepare($sql);
        $query -> bindValue(":raison", $raison);
        $query -> bindValue(":description", $commentaire, PDO::PARAM_STR);
        $query -> bindValue(":idSignaleur", $idClient, PDO::PARAM_INT);
        $query -> bindValue(":idSignaler", 7, PDO::PARAM_INT);
        $query->execute();
        echo "Le signalement a été envoyé avec succès.";
    } else {
        die("Le formulaire est incomplet.");
    }
}

?>