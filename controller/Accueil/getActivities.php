<?php
header('Content-Type: application/json');

require_once("../../Model/Bdd.php");

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : null;
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
    WHERE a.isVisible = 1 AND (a.isDisabled IS NULL OR a.isDisabled = 0) AND (:search = '' OR a.titre LIKE :search OR a.description LIKE :search) AND (a.dateCreation = :date OR :date IS NULL)
    ORDER BY a.dateCreation DESC
    LIMIT :offset, :limit
";

$query = $db->prepare($sql);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
$query->bindValue(':search', $search ? '%' . $search . '%' : '', PDO::PARAM_STR);
$query->bindValue(':date', $date ? $date : null, PDO::PARAM_STR);
$query->execute();

$activities = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($activities);
?>
