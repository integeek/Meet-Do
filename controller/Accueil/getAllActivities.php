<?php
header('Content-Type: application/json');
require_once("../../Model/Bdd.php");

$sql = "
    SELECT 
        a.idActivite,
        a.titre,
        a.adresse,
        a.prix,
        a.tailleGroupe,
        a.theme,
        i.chemin
    FROM Activite a
    LEFT JOIN (
        SELECT idActivite, MIN(chemin) as chemin
        FROM ImageActivite
        GROUP BY idActivite
    ) i ON a.idActivite = i.idActivite
    WHERE a.isVisible = 1 AND (a.isDisabled IS NULL OR a.isDisabled = 0)
    ORDER BY a.dateCreation DESC
";

$query = $db->prepare($sql);
$query->execute();
$activities = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($activities);
?>