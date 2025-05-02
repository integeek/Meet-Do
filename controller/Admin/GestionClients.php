<?php 
session_start(); //METTRE CA SUR TOUTES LES PAGES
require_once("../../model/bddAmbre.php");

$sql = "SELECT nom, prenom, email, role FROM user_valide";
        $query = $db -> prepare($sql);
        $query -> execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
?>