<?php
session_start();
require_once("../../model/Bdd.php");

$nom     = htmlspecialchars(trim($_POST['nom'] ?? ''));
$prenom  = htmlspecialchars(trim($_POST['prenom'] ?? ''));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$objet   = htmlspecialchars(trim($_POST['objet'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));


if (empty($nom) || empty($prenom) || empty($email) || empty($objet) || empty($message)) {
    $_SESSION["erreur_contact"] = "Veuillez remplir tous les champs du formulaire.";
    header("Location: ../../view/Contact.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["erreur_contact"] = "Adresse e-mail invalide.";
    header("Location: ../../view/Contact.php");
    exit;
}

try {
    $sql = "INSERT INTO FormulaireContact (nom, prenom, email, sujet, message, dateEnvoie)
            VALUES (:nom, :prenom, :email, :objet, :message, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':objet' => $objet,
        ':message' => $message
    ]);

    $_SESSION["erreur_contact"] = "Message envoyé avec succès !";
    header("Location: ../../view/Contact.php");
    exit;
} catch (PDOException $e) {
    $_SESSION["erreur_contact"] = "Erreur lors de l'envoi du message.";
    header("Location: ../../view/formulaire.php");
    exit;
}
?>
