<?php 
session_start(); //METTRE CA SUR TOUTES LES PAGES
require_once("../../model/bdd.php");

$sql = "SELECT nom, prenom, email, role FROM Client";
        $query = $db -> prepare($sql);
        $query -> execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
?>