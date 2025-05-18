<?php
session_start();
require_once("../../model/bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idClient = $data["idClient"];
    $nom = $data["nom"];
    $prenom = $data["prenom"];
    $role = $data["role"];

    $sql = "
            UPDATE `Client` SET `nom`=:nom, `prenom`=:prenom, `role`=:role WHERE idClient = :idClient;
        ";
    $query = $db->prepare($sql);
    $query->execute(
        [
            "nom" => $nom,
            "prenom" => $prenom,
            "role" => $role,
            "idClient" => $idClient
        ]
    );

    if (empty($jsonData)) {
        echo json_encode(["message" => "La table est vide."]);
    } else {
        header('Content-Type: application/json');
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
}
