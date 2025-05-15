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

$newLastName = htmlspecialchars($_POST['edit-lastname']);

if (empty($newLastName)) {
    $_SESSION['error'] = "Le nom ne peut pas être vide.";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

if (!preg_match("/^[a-zA-ZÀ-ÿ\-'\s]{2,50}$/u", $newLastName)) {
    $_SESSION['error'] = "Le nom est invalide. Utilisez uniquement des lettres, espaces, tirets ou apostrophes (2 à 50 caractères).";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

if ($_SESSION['user']['nom'] === $newLastName) {
    $_SESSION['error'] = "Le nom est identique à l'ancien nom.";
    header("Location: ../../view/page/PageCompte.php");
    exit;
}

$sql = "UPDATE Client SET nom = :newLastName WHERE idClient = :idClient";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':newLastName' => $newLastName,
    ':idClient' => $idClient
]);

if ($stmt->rowCount() > 0) {
    $_SESSION['user']['nom'] = $newLastName;
    $_SESSION['success'] = "Le nom a été modifié avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la modification du nom.";
    exit;
}

header("Location: ../../view/page/PageCompte.php");
exit;

?>