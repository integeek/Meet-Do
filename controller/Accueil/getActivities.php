<?php
header('Content-Type: application/json');

require_once("../../model/Bdd.php");

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 6;

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
    LIMIT :offset, :limit
";

$query = $db->prepare($sql);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
$query->execute();

$activities = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($activities);
?>
