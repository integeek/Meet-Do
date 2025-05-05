<?php 
session_start();

require_once("../../model/Bdd.php");

if(!empty($_POST)){
    if(isset($_POST["email"],$_POST["password"]) && !empty(($_POST["email"]) && !empty($_POST["password"]))) {
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erreur"] = "L'adresse email est incorrecte.";
            header("Location: ../../view/Page/Connexion.php");
        }

        $sql = "SELECT * FROM user_valide WHERE email = :email";
        $query = $db -> prepare($sql);
        $query -> bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query -> execute();

        $user = $query -> fetch();
        
        if(!$user){
            $_SESSION["erreur"] = "L'utilisateur et/ou le mot de passe n'existe pas";
            header("Location: ../../view/Page/Connexion.php");
        }

        if(!password_verify($_POST["password"], $user["password"])){
            $_SESSION["erreur"] = "L'utilisateur et/ou le mot de passe n'existe pas";
            header("Location: ../../view/Page/Connexion.php");
        }

        session_start();
         
        $_SESSION["user"] = [
            "id" => $user["id"],
            "email" => $user["email"],
        ];
        header("Location: ../../view/Page/FAQ.html");

    } else {
        $_SESSION["erreur"] = "Le formulaire est incomplet.";
            header("Location: ../../view/Page/Connexion.php");
    }
}
?>