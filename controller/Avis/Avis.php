<?php
session_start();
require_once '../../Model/Avis.php';

if (!empty($_POST)) {
    $note = isset($_POST['star-rating']) ? intval($_POST['star-rating']) : null;
    $commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : null;
    $idActivite = isset($_POST['idActivite']) ? intval($_POST['idActivite']) : null;
    $idClient = $_SESSION['user']['id'] ?? null;

    Avis::checkByIdAndActivity($idClient, $idActivite);
    if (Avis::checkByIdAndActivity($idClient, $idActivite)) {
        $_SESSION['erreur'] = "Vous avez déjà laissé un avis pour cette activité.";
        header("Location: ../../view/Page/activite.php?id=$idActivite");
        exit;
    }

    Avis::create($note, $commentaire, $idActivite, $idClient);

    header("Location: ../../view/Page/activite.php?id=$idActivite");
}
?>