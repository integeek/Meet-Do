<?php 
session_start(); //METTRE CA SUR TOUTES LES PAGES
if(!empty($_POST)){
    //var_dump(value: $_POST);
    if(isset($_POST["email"],$_POST["password"]) && !empty(($_POST["email"]) && !empty($_POST["password"]))) {
        // $email = strip_tags($_POST["email"]);
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("l'adresse email est incorrecte");
        }

        $password = $_POST["password"];

        if(strlen($password) < 8){
            die("Le mot de passe doit contenir au moins 8 caractères");
        }

        if(!preg_match("/[0-9]/", $password)){
            die("Le mot de passe doit contenir au moins un chiffre");
        }

        if(!preg_match("/[A-Z]/", $password)){
            die("Le mot de passe doit contenir au moins une majuscule");
        }

        if(!preg_match("/[a-z]/", $password)){
            die("Le mot de passe doit contenir au moins une minuscule");
        }

        $pass = password_hash($password, PASSWORD_ARGON2ID);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";
        $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkEmail = $db->prepare("SELECT id FROM user WHERE email = :email");
        $checkEmail->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $checkEmail->execute();
    
        if($checkEmail->fetch()){
            die("Cette adresse email est déjà utilisée.");
        }
        
        $sql = "INSERT INTO user (email, password) VALUES (:email, '$pass')";

        $query = $db -> prepare($sql);
        $query -> bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query -> execute();

        $id = $db->lastInsertId();

        session_start();
         
        $_SESSION["user"] = [
            "id" => $id,
            "email" => $_POST["email"],
        ];
        header("Location: ../../view/Page/FAQ.html");

    } else {
        die("le formulaire est incomplet");
    }
}
?>