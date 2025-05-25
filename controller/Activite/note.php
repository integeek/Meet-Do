<?php
header('Content-Type: application/json');
require_once("../../Model/Bdd.php");

// Vérifier que les données nécessaires sont envoyées
$input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input['idActivite']) ||
    !isset($input['note']) ||
    !isset($input['commentaire'])
) {
    http_response_code(400);
    echo json_encode(["error" => "Champs requis manquants."]);
    exit;
}

$idActivite = intval($input['idActivite']);
$note = intval($input['note']);
$commentaire = trim($input['commentaire']);

// Validation des valeurs
if ($note < 1 || $note > 5) {
    http_response_code(400);
    echo json_encode(["error" => "La note doit être comprise entre 1 et 5."]);
    exit;
}

if ($idActivite <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "ID d'activité invalide."]);
    exit;
}

// Préparation de la requête d'insertion
$sqlInsert = "
    INSERT INTO Avis (idActivite, note, commentaire, dateAvis)
    VALUES (:idActivite, :note, :commentaire, NOW())
";

try {
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':idActivite', $idActivite, PDO::PARAM_INT);
    $stmt->bindValue(':note', $note, PDO::PARAM_INT);
    $stmt->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);

    $stmt->execute();

    http_response_code(201);
    echo json_encode(["message" => "Avis ajouté avec succès."]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de l'insertion de l'avis : " . $e->getMessage()]);
}
?>
