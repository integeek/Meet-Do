<?php
require_once("../../model/Bdd.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $param = $_SESSION['user']['id'];
    $sql =
        "
        SELECT 
        CONCAT(Client.nom, ' ', Client.prenom) AS 'name', 
        (SELECT Message.contenu FROM Message WHERE (Message.idRedacteur = :clientId OR Message.idRecepteur = :clientId) AND (Message.idRedacteur = Client.idClient OR Message.idRecepteur = Client.idClient) ORDER BY Message.dateEnvoie DESC LIMIT 1) AS 'last_message',
        Client.idClient AS 'idClient'
        FROM `Message`
        INNER JOIN Client ON Client.idClient = Message.idRedacteur OR Client.idClient = Message.idRecepteur
        WHERE (Message.idRedacteur = :clientId OR Message.idRecepteur = :clientId)
        AND Client.idClient != :clientId
        GROUP BY CONCAT(Client.nom, ' ', Client.prenom);
    ";
    $query = $db->prepare($sql);
    $query->execute(
        [
            'clientId' => $param
        ]
    );
    $jsonData = $query->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes

    if (empty($jsonData)) {
        echo json_encode(["message" => "La table est vide."]);
    } else {
        header('Content-Type: application/json');
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
} else {
    exit();
}
?>
