<?php
session_start();
require_once("../../model/Client.php");

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

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

$modif = Client::modifierPrenom($idClient, $newFirstName);

if ($modif) {
    $_SESSION['user']['prenom'] = $newFirstName;
    $_SESSION['success'] = "Le prénom a été modifié avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la modification du prénom.";
    exit;
}

header("Location: ../../view/page/PageCompte.php");
exit;

?>