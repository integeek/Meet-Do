<?php
require_once("../../model/Bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $idMessage = $data["idMessage"];
        $idUser = $data["idUser"];
        $message = $data["message"];

        $sql = "
            INSERT INTO `MessageForum`(`message`, `dateEnvoie`, `idSujetForum`, `idRedacteur`) VALUES (:message, NOW(), :idMessage, :idUser)
        ";
        $query = $db->prepare($sql);
        $query->execute(
            [
                "message" => $message,
                "idMessage" => $idMessage,
                "idUser" => $idUser
            ]
        );

        echo json_encode([
            "success" => true,
            "message" => "Message ajouté avec succès."
        ], JSON_UNESCAPED_UNICODE);
    }
    catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de la récupération des données : " . $e->getMessage()]);
    }
} else {
    exit();
}
?>