<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $message = $data['message'];
    $userName = $data['userName'];
    $email = $data['email'];
    $sujet = $data['sujet'];
    $id = $data['id'];

    echo json_encode($data);
    // envoyé le mail

    $sql = "DELETE FROM `FormulaireContact` WHERE `idFormulaireContact` = :id;";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "id" => $id
        ]
    );

    if ($query->rowCount() > 0) {
        echo json_encode(["message" => "Réponse envoyée avec succès."]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression du signalement."]);
    }

}
?>