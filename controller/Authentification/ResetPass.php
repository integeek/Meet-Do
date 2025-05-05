<?php
require_once("../../model/Bdd.php");

$token = $_GET["token"];
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
    echo "token valid";
    
?>