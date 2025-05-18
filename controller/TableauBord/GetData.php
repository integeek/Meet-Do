<?php
require_once("../../model/Bdd.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql1 = "SELECT COUNT(*) AS 'number' FROM `Client`;";
    $query = $db->prepare($sql1);
    $query->execute();
    $nombreClient = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "SELECT COUNT(*) AS 'number' FROM `Activite` WHERE DAY(Activite.dateCreation) = DAY(NOW());";
    $query = $db->prepare($sql2);
    $query->execute();
    $nombreActivite = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql3 = "SELECT Categorie.nom AS 'activity', COUNT(*) AS 'number' FROM Activite INNER JOIN Categorie ON Categorie.idCategorie = Activite.theme GROUP BY Categorie.nom;";
    $query = $db->prepare($sql3);
    $query->execute();
    $nombreActiviteTheme = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql4 = "
        SELECT    
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'janvier',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'fevrier',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'mars',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'avril',
            SUM(CASE MONTH(dateCreation) WHEN 5 THEN 1 ELSE 0 END) AS 'mai',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'juin',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'juillet',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'aout',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'septembre',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'octobre',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'novembre',
            SUM(CASE MONTH(dateCreation) WHEN 1 THEN 1 ELSE 0 END) AS 'decembre'
        FROM Activite;";
    $query = $db->prepare($sql4);
    $query->execute();
    $nombreActiviteMois = $query->fetchAll(PDO::FETCH_ASSOC);

    $jsonData = [
        "nombreClient" => $nombreClient,
        "nombreActivite" => $nombreActivite,
        "nombreActiviteTheme" => $nombreActiviteTheme,
        "nombreActiviteParMois" => $nombreActiviteMois
    ];


    if (empty($jsonData)) {
        echo json_encode(["message" => "La table est vide."]);
    } else {
        header('Content-Type: application/json');
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
} else {
    exit();
}
