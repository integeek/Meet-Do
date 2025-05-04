<?php
require_once("../../model/bddAmbre.php");

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM user_valide WHERE reset_token_hash = :reset_token";
$query = $db -> prepare($sql);
    $query->execute([
        "reset_token" => $token_hash,
    ]);

    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result ==  null){
        die("token not found");

    }
    if (strtotime($result["reset_token_expires_at"]) < time()){
        die("token expired");
    }

    $password = $_POST["pass1"];
    $password2 = $_POST["pass2"];
    if($password != $password2){
        die("Les mots de passe ne correspondent pas");
    }


        if(strlen($password) < 8){
            $_SESSION["erreur"] = "Le mot de passe doit contenir au moins 8 caractères";
            header("Location: ../../view/Page/Inscription.php");
        }

        if(!preg_match("/[0-9]/", $password)){
            $_SESSION["erreur"] = "Le mot de passe doit contenir au moins un chiffre";
            header("Location: ../../view/Page/Inscription.php");
        }

        if(!preg_match("/[A-Z]/", $password)){
            $_SESSION["erreur"] = "Le mot de passe doit contenir au moins une majuscule";
            header("Location: ../../view/Page/Inscription.php");
        }

        if(!preg_match("/[a-z]/", $password)){
            $_SESSION["erreur"] = "Le mot de passe doit contenir au moins une minuscule";
            header("Location: ../../view/Page/Inscription.php");
        }

        $pass = password_hash($password, PASSWORD_ARGON2ID);

        $sql = "UPDATE user_valide SET password= :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id=:id";

        $query = $db -> prepare($sql);
        $query->execute([
                    "password" => $pass,
                    "id" => $result["id"],
                ]);
        
        echo "Mot de passe mis à jour avec succès !";
?>