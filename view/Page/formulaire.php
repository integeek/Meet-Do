<?php

$host = "144.76.54.100";  
$dbname = "test";         
$username = "root";       
$password = "";          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$last_name = $_POST['last_name'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';


$sql = "INSERT INTO test (last_name, first_name, email, subject, message)
        VALUES (:last_name, :first_name, :email, :subject, :message)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':last_name' => $last_name,
    ':first_name' => $first_name,
    ':email' => $email,
    ':subject' => $subject,
    ':message' => $message
]);

echo " Message envoyé avec succès !";
?>