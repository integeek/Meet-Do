<?php

// $host = "144.76.54.100";
// $dbname = "test";
// $username = "root";
// $password = "";

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
// } catch (PDOException $e) {
//     die("Erreur de connexion : " . $e->getMessage());
// }
include "../../Model/bdd.php";

$last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
$first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));


if ($last_name && $first_name && $email && $subject && $message) {
    
    $sql = "INSERT INTO FormulaireContact (last_name, first_name, email, subject, message)
            VALUES (:last_name, :first_name, :email, :subject, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':last_name' => $last_name,
        ':first_name' => $first_name,
        ':email' => $email,
        ':subject' => $subject,
        ':message' => $message
    ]);

    echo "Message envoyé avec succès !";
} else {
    echo "Veuillez remplir tous les champs du formulaire.";
}
?>