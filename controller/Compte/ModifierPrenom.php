<?php
session_start();

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

require_once("../../model/Bdd.php");

if (isset($_POST['idClient'])) {
    $idClient = $_POST['idClient'];
} else {
    echo "Erreur : idClient manquant.";
    exit;
}

$newFirstName = htmlspecialchars($_POST['edit-firstname']);

if (empty($newFirstName)) {
    $_SESSION['error'] = "Le prénom ne peut pas être vide.";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

if (!preg_match("/^[a-zA-ZÀ-ÿ\-'\s]{2,50}$/u", $newFirstName)) {
    $_SESSION['error'] = "Le prénom est invalide. Utilisez uniquement des lettres, espaces, tirets ou apostrophes (2 à 50 caractères).";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

if ($_SESSION['user']['prenom'] === $newFirstName) {
    $_SESSION['error'] = "Le prénom est identique à l'ancien prénom.";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

$sql = "UPDATE Client SET prenom = :newFirstName WHERE idClient = :idClient";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':newFirstName' => $newFirstName,
    ':idClient' => $idClient
]);

if ($stmt->rowCount() > 0) {
    $_SESSION['user']['prenom'] = $newFirstName;
    $_SESSION['success'] = "Le prénom a été modifié avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la modification du prénom.";
    exit;
}

header("Location: ../../view/page/PageCompte.php");
exit;

?>