
<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idMeeter = $data["idMeeter"];

    $sql = "DELETE FROM `Meeter` WHERE idMeeter = :idMeeter;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "idMeeter" => $idMeeter
        ]
    );

    if ($query->rowCount() > 0) {
        echo json_encode(["message" => "Demande de meeter rejetée."]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression du signalement."]);
    }

}
?>