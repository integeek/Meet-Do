<?php
header('Content-Type: application/json');

require_once("../../model/Bdd.php");

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Paramètre 'id' manquant."]);
    exit;
}

$id = intval($_GET['id']);

// Requête principale sans filtre de visibilité ou désactivation
$sqlActivite = "
    SELECT 
        a.idActivite,
        a.titre,
        a.description,
        a.mobiliteReduite,
        a.adresse,
        a.theme,
        a.tailleGroupe,
        a.isVisible,
        a.isDisabled,
        a.dateCreation,
        a.prix,
        a.idMeeter,
        m.description AS meeterDescription
    FROM Activite a
    INNER JOIN Meeter m ON a.idMeeter = m.idMeeter
    WHERE a.idActivite = :id
    LIMIT 1
";

$query = $db->prepare($sqlActivite);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

$activity = $query->fetch(PDO::FETCH_ASSOC);

if (!$activity) {
    http_response_code(404);
    echo json_encode(["error" => "Activité introuvable."]);
    exit;
}

// Requête pour les images associées
$sqlImages = "
    SELECT chemin
    FROM ImageActivite
    WHERE idActivite = :id
";

$queryImages = $db->prepare($sqlImages);
$queryImages->bindValue(':id', $id, PDO::PARAM_INT);
$queryImages->execute();

$images = $queryImages->fetchAll(PDO::FETCH_COLUMN);
$activity["images"] = $images ?: [];

// Requête pour les avis
$sqlAvis = "
    SELECT 
        idAvis,
        note,
        commentaire,
        dateAvis
    FROM Avis
    WHERE idActivite = :id
    ORDER BY dateAvis DESC
";

$queryAvis = $db->prepare($sqlAvis);
$queryAvis->bindValue(':id', $id, PDO::PARAM_INT);
$queryAvis->execute();

$avis = $queryAvis->fetchAll(PDO::FETCH_ASSOC);
$activity["avis"] = $avis ?: [];

// Moyenne + nombre d’avis
$sqlStats = "
    SELECT 
        COUNT(*) AS nombreAvis,
        ROUND(AVG(note), 1) AS moyenneAvis
    FROM Avis
    WHERE idActivite = :id
";

$queryStats = $db->prepare($sqlStats);
$queryStats->bindValue(':id', $id, PDO::PARAM_INT);
$queryStats->execute();

$stats = $queryStats->fetch(PDO::FETCH_ASSOC);
$activity["nombreAvis"] = intval($stats["nombreAvis"]);
$activity["moyenneAvis"] = $stats["moyenneAvis"] !== null ? floatval($stats["moyenneAvis"]) : null;

// Envoi final des données JSON
echo json_encode($activity);
