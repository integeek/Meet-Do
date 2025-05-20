<?php
require_once(__DIR__ . "/../Bdd.php");

class MeeterModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getDemandes($search = "") {
        if ($search !== "") {
            $sql = "SELECT Client.nom, Client.prenom, Meeter.idMeeter AS id, Meeter.dateDemandeMeeter AS date, Meeter.description, Meeter.adresse, Meeter.telephone, Meeter.idClient
                    FROM Meeter
                    INNER JOIN Client ON Client.idClient = Meeter.idClient
                    WHERE Client.nom LIKE :search OR Client.prenom LIKE :search OR Meeter.dateDemandeMeeter LIKE :search";
            $query = $this->db->prepare($sql);
            $like = "%$search%";
            $query->bindParam(':search', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT Client.nom, Client.prenom, Meeter.idMeeter AS id, Meeter.dateDemandeMeeter AS date, Meeter.description, Meeter.adresse, Meeter.telephone, Meeter.idClient
                    FROM Meeter
                    INNER JOIN Client ON Client.idClient = Meeter.idClient";
            $query = $this->db->prepare($sql);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function refuseMeeter($idMeeter) {
        $sql = "DELETE FROM Meeter WHERE idMeeter = :idMeeter";
        $query = $this->db->prepare($sql);
        return $query->execute(['idMeeter' => $idMeeter]);
    }

    public function acceptMeeter($idClient, $idMeeter, $telephone, $adresse, $description) {
        $sql = "UPDATE Client SET role = 'Meeter', localisation = :adresse, description = :description, telephone = :telephone WHERE idClient = :idClient";
        $query = $this->db->prepare($sql);
        $query->execute([
            'idClient' => $idClient,
            'adresse' => $adresse,
            'description' => $description,
            'telephone' => $telephone
        ]);

        $sql = "DELETE FROM Meeter WHERE idMeeter = :idMeeter";
        $query = $this->db->prepare($sql);
        return $query->execute(['idMeeter' => $idMeeter]);
    }
}
?>