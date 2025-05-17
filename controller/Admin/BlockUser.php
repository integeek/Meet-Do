
<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idClient = $data["idClient"];

    $sql = "UPDATE `Client` SET `isBloqued`= '1' WHERE Client.idClient = :idClient;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idClient" => $idClient
        ]
    );

    $sql = "DELETE FROM `Signalement` WHERE Signalement.idSignaler = :idClient;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idClient" => $idClient
        ]
    );

    if ($query->rowCount() > 0) {
        echo json_encode(["message" => "Signalement supprimé avec succès."]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression du signalement."]);
    }

}
?>