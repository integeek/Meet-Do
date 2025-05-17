
<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idActivite = $data["idActivite"];

    $sql = "UPDATE `Activite` SET `isDisabled`= '1' WHERE Activite.idActivite = :idActivite;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idActivite" => $idActivite
        ]
    );

    $sql = "DELETE FROM `Signalement` WHERE Signalement.idActivite = :idActivite;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idActivite" => $idActivite
        ]
    );

    if ($query->rowCount() > 0) {
        echo json_encode(["message" => "Signalement supprimé avec succès."]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression du signalement."]);
    }

}
?>