<?php 
if(!empty($_POST)){
    //var_dump(value: $_POST);
    if(isset($_POST["email"],$_POST["password"]) && !empty(($_POST["email"]) && !empty($_POST["password"]))) {
        // $email = strip_tags($_POST["email"]);
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("l'adresse email est incorrecte");
        }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";
        $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM user_valide WHERE email = :email";
        $query = $db -> prepare($sql);
        $query -> bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query -> execute();

        $user = $query -> fetch();
        
        if(!$user){
            die("l'utilisateur et/ou le mot de passe n'existe pas");
        }

        if(!password_verify($_POST["password"], $user["password"])){
            die("l'utilisateur et/ou le mot de passe n'existe pas");
        }

        session_start();
         
        $_SESSION["user"] = [
            "id" => $user["id"],
            "email" => $user["email"],
        ];
        header("Location: ../../view/Page/FAQ.html");

    } else {
        die("le formulaire est incomplet");
    }
}
?>