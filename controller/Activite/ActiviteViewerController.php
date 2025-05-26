<?php
header('Content-Type: application/json');

require_once("../../Model/Bdd.php");
require_once("../../Model/Activite/activiteModel.php");

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Paramètre 'id' manquant."]);
    exit;
}

$id = intval($_GET['id']);


$activity = ActiviteModel::getActiviteById($id);
if (!$activity) {
    http_response_code(404);
    echo json_encode(["error" => "Activité non trouvée ou masquée."]);
    exit;
}

$activity["evenements"] = ActiviteModel::getEvenementsByActiviteId($id) ?: [];
$activity["images"] = ActiviteModel::getImagesByActiviteId($id) ?: [];
$activity["avis"] = ActiviteModel::getAvisByActiviteId($id) ?: [];

$stats = ActiviteModel::getStatsAvisByActiviteId($id);
$activity["nombreAvis"] = intval($stats["nombreAvis"]);
$activity["moyenneAvis"] = $stats["moyenneAvis"] !== null ? floatval($stats["moyenneAvis"]) : null;

echo json_encode($activity); 
