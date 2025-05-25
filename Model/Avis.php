<?php
require_once("Bdd.php");

Class Formulaire {
    public static function create($note, $commentaire, $idActivite, $idClient) {
                $db = Bdd::getInstance();
                $sql = "INSERT INTO Avis (note, commentaire, dateAvis, idClient, idActivite) VALUES (:note, :commentaire, NOW(), :idClient, :idActivite)";
                $query = $db->prepare(query: $sql);
                $query->bindValue(':note', $note);
                $query->bindValue(':commentaire', $commentaire);
                $query->bindValue(':idClient', $idClient);
                $query->bindValue(':idActivite', $idActivite);
                $query->execute();
            }
}
?>