<?php
require_once("Bdd.php");

Class Evenement {
    public static function selectEvenement($date, $heure) {
        $db = Bdd::getInstance();
        $sql = "SELECT idEvenement FROM Evenement WHERE DATE(dateEvenement) = :date AND HOUR(dateEvenement) = :heure";
        $query = $db->prepare(query: $sql);
        $query->bindValue(':date', $date);
        $query->bindValue(':heure', intval(explode(":", $heure)[0]));
        $query->execute();
        return $query->fetchColumn();
    }

    public static function updatePlacePrise($idEvenement, $nbPlace) {
        $db = Bdd::getInstance();
        $sql = "UPDATE Evenement SET placePrise = COALESCE(placePrise, 0) + :nbPlace WHERE idEvenement = :idEvenement";
        $query = $db->prepare($sql);
        $query->bindValue(':nbPlace', $nbPlace, PDO::PARAM_INT);
        $query->bindValue(':idEvenement', $idEvenement, PDO::PARAM_INT);
        return $query->execute();
    }

    public static function selectDateEvenement($idActivite) {
        $db = Bdd::getInstance();
        $sql = "SELECT dateEvenement, placePrise FROM Evenement WHERE idActivite = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idActivite, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC); // 🔁 On récupère chaque ligne sous forme de tableau associatif
}

}
?>