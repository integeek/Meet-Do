<?php
require_once(__DIR__ . "/../Bdd.php");

class ClientModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getClients($search = "") {
        if ($search !== "") {
            $sql = "SELECT idClient AS id, nom, prenom, email, role FROM Client WHERE nom LIKE :search OR prenom LIKE :search OR email LIKE :search";
            $query = $this->db->prepare($sql);
            $like = "%$search%";
            $query->bindParam(':search', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT idClient AS id, nom, prenom, email, role FROM Client";
            $query = $this->db->prepare($sql);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateClient($idClient, $nom, $prenom, $role) {
        $sql = "UPDATE Client SET nom = :nom, prenom = :prenom, role = :role WHERE idClient = :idClient";
        $query = $this->db->prepare($sql);
        return $query->execute([
            "nom" => $nom,
            "prenom" => $prenom,
            "role" => $role,
            "idClient" => $idClient
        ]);
    }

    public function deleteClient($idClient) {
        $sql = "DELETE FROM Client WHERE idClient = :idClient";
        $query = $this->db->prepare($sql);
        return $query->execute(["idClient" => $idClient]);
    }
}
?>