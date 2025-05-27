<?php
session_start();
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bonjour <?= $_SESSION["user"]["email"]; ?></p>
    <p>Bonjour <?= $_SESSION["user"]["id"]; ?></p>
    <p>Bonjour <?= $_SESSION["user"]["nom"]; ?></p>
    <p>Bonjour <?= $_SESSION["user"]["prenom"]; ?></p>
    <p>Bonjour <?= $_SESSION["user"]["adresse"]; ?></p>
    <p>Bonjour <?= $_SESSION["user"]["role"]; ?></p>
    
</body>
</html>