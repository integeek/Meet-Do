
<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idClient = $data["idClient"];
    $idMeeter = $data["idMeeter"];
    $telephone = $data["telephone"];
    $adresse = $data["adresse"];
    $description = $data["description"];

    $sql = "UPDATE `Client` SET `role`='Meeter', `localisation`= :adresse, `description`= :description, `telephone`= :telephone WHERE Client.idClient = :idClient;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idClient" => $idClient,
            "adresse" => $adresse,
            "description" => $description,
            "telephone" => $telephone
        ]
    );

    $sql = "DELETE FROM `Meeter` WHERE idMeeter = :idMeeter;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idMeeter" => $idMeeter
        ]
    );

    if ($query->rowCount() > 0) {
        echo json_encode(["message" => "Nouveau Meeter"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression du signalement."]);
    }

}
?>