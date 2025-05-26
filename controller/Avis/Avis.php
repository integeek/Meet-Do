<?php
session_start();
require_once '../../Model/Avis.php';

if (!empty($_POST)) {
    $note = isset($_POST['star-rating']) ? intval($_POST['star-rating']) : null;
    $commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : null;
    $idActivite = isset($_POST['idActivite']) ? intval($_POST['idActivite']) : null;
    $idClient = $_SESSION['user']['id'] ?? null;

    Avis::create($note, $commentaire, $idActivite, $idClient);

        header("Location: ../../view/Page/activite.php?id=$idActivite");
}
?>