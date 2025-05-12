<?php
require_once("../../model/Bdd.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $param = $_SESSION['user']['id'];
    $param2 = $_GET['id'];
    $sql =
        "
    SELECT
        Message.idMessage AS 'id',
        CONCAT(sender.nom, ' ', sender.prenom) AS 'sender',
        sender.idClient AS 'senderId',
        DATE(Message.dateEnvoie) AS 'date',
        TIME(Message.dateEnvoie) AS 'time',
        Message.contenu AS 'content',
        Message.attachement AS 'attachement'
    FROM
        `Message`
    INNER JOIN
        Client AS sender ON sender.idClient = Message.idRedacteur
    INNER JOIN
        Client AS receiver ON receiver.idClient = Message.idRecepteur
    WHERE
        (
            (Message.idRedacteur = :clientId AND Message.idRecepteur = :clientMessage)
            OR
            (Message.idRedacteur = :clientMessage AND Message.idRecepteur = :clientId)
        )
    ORDER BY
        Message.idMessage;
    ";
    $query = $db->prepare($sql);
    $query->execute(
        [
            'clientId' => $param,
            'clientMessage' => $param2
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
