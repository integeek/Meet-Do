<?php
session_start();

$host = "144.76.54.100";
$dbname = "test";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION["erreur_contact"] = "Erreur de connexion à la base de données.";
    header("Location: ../../view/Contact.php");
    exit;
}

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
    $sql = "INSERT INTO test (nom, prenom, email, objet, message)
            VALUES (:nom, :prenom, :email, :objet, :message)";
    $stmt = $pdo->prepare($sql);
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
    header("Location: ../../view/Contact.php");
    exit;
}
?>
