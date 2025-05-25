<?php
session_start();
require_once '../../Model/Avis.php';

if (!empty($_POST)) {
    $note = isset($_POST['star-rating']) ? intval($_POST['star-rating']) : null;
    $commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : null;
    $idActivite = isset($_POST['idActivite']) ? intval($_POST['idActivite']) : null;
    $idClient = $_SESSION['user']['id'] ?? null;

    $sql = "INSERT INTO Avis (note, commentaire, dateAvis, idClient, idActivite) VALUES (:note, :commentaire, NOW(), :idClient, :idActivite)";
        $query = $db->prepare(query: $sql);
        $query->bindValue(':note', $note);
        $query->bindValue(':commentaire', $commentaire);
        $query->bindValue(':idClient', $idClient);
        $query->bindValue(':idActivite', $idActivite);
        $query->execute();

        header("Location: ../../view/Page/activite.php?id=$idActivite");
}
?>