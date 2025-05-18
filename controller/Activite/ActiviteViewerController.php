<?php
header('Content-Type: application/json');

require_once("../../model/Bdd.php");

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Paramètre 'id' manquant."]);
    exit;
}

$id = intval($_GET['id']);

// Requête principale pour l'activité + description du meeter
$sqlActivite = "
    SELECT 
        a.idActivite,
        a.titre,
        a.description,
        a.adresse,
        a.theme,
        a.tailleGroupe,
        a.dateCreation,
        a.prix,
        a.idMeeter,
        m.description AS meeterDescription
    FROM Activite a
    INNER JOIN Client m ON a.idMeeter = m.idClient
    WHERE a.idActivite = :id
      AND a.isVisible = 1
      AND (a.isDisabled IS NULL OR a.isDisabled = 0)
    LIMIT 1
";

$query = $db->prepare($sqlActivite);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

$activity = $query->fetch(PDO::FETCH_ASSOC);

if (!$activity) {
    http_response_code(404);
    echo json_encode(["error" => "Activité non trouvée ou masquée."]);
    exit;
}

// Requête pour toutes les images associées à l'activité
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
