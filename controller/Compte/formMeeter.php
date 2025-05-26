<?php
session_start();

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

require_once("../../Model/Bdd.php");

if (isset($_POST['idClient'])) {
    $idClient = $_POST['idClient'];
} else {
    echo "Erreur : idClient manquant.";
    exit;
}

$adresse = htmlspecialchars($_POST['adresse-meeter']);
$description = htmlspecialchars($_POST['description-meeter']);
$telephone = htmlspecialchars($_POST['telephone-meeter']);

$sql = "UPDATE Client SET localisation = :adresse, description = :description, telephone = :telephone WHERE idClient = :idClient";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':adresse' => $adresse,
    ':description' => $description,
    ':telephone' => $telephone,
    ':idClient' => $idClient
]);

if ($stmt->rowCount() > 0) {
    $_SESSION['user']['adresse'] = $adresse;
    $_SESSION['success'] = "Votre demande a été envoyée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lié à votre adresse.";
    exit;
}

header("Location: ../../view/page/Devenir-Meeter");
exit;

?>