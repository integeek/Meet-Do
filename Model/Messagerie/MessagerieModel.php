<?php
require_once(__DIR__ . "/../Bdd.php");

class MessagerieModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUsers($userId)
    {
        $sql = "
            SELECT 
                CONCAT(Client.nom, ' ', Client.prenom) AS 'name', 
                (SELECT Message.contenu FROM Message WHERE (Message.idRedacteur = :clientId OR Message.idRecepteur = :clientId) AND (Message.idRedacteur = Client.idClient OR Message.idRecepteur = Client.idClient) ORDER BY Message.dateEnvoie DESC LIMIT 1) AS 'last_message',
                Client.idClient AS 'idClient'
            FROM `Message`
            INNER JOIN Client ON Client.idClient = Message.idRedacteur OR Client.idClient = Message.idRecepteur
            WHERE (Message.idRedacteur = :clientId OR Message.idRecepteur = :clientId)
            AND Client.idClient != :clientId
            GROUP BY CONCAT(Client.nom, ' ', Client.prenom)
        ";
        $query = $this->db->prepare($sql);
        $query->execute(['clientId' => $userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessages($userId, $otherId)
    {
        $sql = "
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
                Message.idMessage
        ";
        $query = $this->db->prepare($sql);
        $query->execute([
            'clientId' => $userId,
            'clientMessage' => $otherId
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMessage($content, $idRedacteur, $idRecepteur, $file = null)
    {
        $attachement = (!empty($file) && $file !== "false" && $file !== false) ? 1 : 0;

        $sql = "
        INSERT INTO `Message`(`contenu`, `dateEnvoie`, `isRead`, `attachement`, `idRedacteur`, `idRecepteur`) 
        VALUES (:content, NOW(), FALSE, :attachement, :idRedacteur, :idRecepteur)
    ";
        $query = $this->db->prepare($sql);
        return $query->execute([
            'content' => $content,
            'attachement' => $attachement,
            'idRedacteur' => $idRedacteur,
            'idRecepteur' => $idRecepteur
        ]);
    }

    public function contact($userId, $meeterId, $activityName)
    {
        $sql = "
            INSERT INTO `Message`(`contenu`, `dateEnvoie`, `isRead`, `attachement`, `idRedacteur`, `idRecepteur`) 
            VALUES (:content, NOW(), FALSE, 0, :idRedacteur, :idRecepteur)
        ";
        $query = $this->db->prepare($sql);
        return $query->execute([
            'content' => "Bonjour, je suis intéressé par l'activité $activityName",
            'idRedacteur' => $userId,
            'idRecepteur' => $meeterId
        ]);
    }
}
