<?php 
session_start();
require_once("../../Model/Client.php");

if(!empty($_POST)){
    if(isset($_POST["email"],$_POST["password"]) && !empty(($_POST["email"]) && !empty($_POST["password"]))) {
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erreur"] = "L'adresse email est incorrecte.";
            header("Location: ../../view/Page/Connexion.php");
            exit;
        }

        $user = Client::connexion($_POST["email"]);
        
        if(!$user){
            $_SESSION["erreur"] = "L'utilisateur et/ou le mot de passe n'existe pas";
            header("Location: ../../view/Page/Connexion.php");
            exit;
        }

        if(!password_verify($_POST["password"], $user["password"])){
            $_SESSION["erreur"] = "L'utilisateur et/ou le mot de passe n'existe pas";
            header("Location: ../../view/Page/Connexion.php");
            exit;
        }

        session_start();
         
        $_SESSION["user"] = [
            "id" => $user["idClient"],
            "email" => $user["email"],
            "nom" => $user["nom"],
            "prenom" => $user["prenom"],
            "adresse" => $user["localisation"],
            "role" => $user["role"],

        ];
        header("Location: ../../view/Page/accueil.php");

    } else {
        $_SESSION["erreur"] = "Le formulaire est incomplet.";
            header("Location: ../../view/Page/Connexion.php");
            exit;
    }
}
?>