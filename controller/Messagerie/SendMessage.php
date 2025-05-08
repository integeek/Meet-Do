<?php
require_once("../../model/Bdd.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $param = $_SESSION['user']['id'];

        $content = $data["content"];
        $idRecepteur = $data["idRecepteur"];
        $file = isset($data["file"]) && $data["file"] !== "false" ? $data["file"] : null;

        $sql = "
            INSERT INTO `Message`(`contenu`, `dateEnvoie`, `isRead`, `attachement`, `idRedacteur`, `idRecepteur`) VALUES (:content, NOW(), FALSE, FALSE, :param, :idRecepteur);
        ";
        $query = $db->prepare($sql);
        $query->execute(
            [
                'content' => $content,
                // 'file' => $file,
                'param' => $param,
                'idRecepteur' => $idRecepteur
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