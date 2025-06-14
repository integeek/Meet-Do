<?php
// /Model/Activite/activiteModel.php

require_once(__DIR__ . "/../Bdd.php");

class ActiviteModel
{
    public static function getActiviteById($id)
    {
        $db = Bdd::getInstance();
        $sql = "
            SELECT 
                a.idActivite,
                a.titre,
                a.description,
                a.mobiliteReduite,
                a.adresse,
                a.theme,
                a.tailleGroupe,
                a.dateCreation,
                a.prix,
                a.idMeeter,
                m.description AS descriptionMeeter,
                m.nom AS nom,
                m.prenom AS prenom
            FROM Activite a
            INNER JOIN Client m ON a.idMeeter = m.idClient
            WHERE a.idActivite = :id
              AND a.isVisible = 1
              AND (a.isDisabled IS NULL OR a.isDisabled = 0)
            LIMIT 1
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function getEvenementsByActiviteId($id)
    {
        $db = Bdd::getInstance();
        $sql = "
            SELECT 
                idEvenement,
                dateEvenement
            FROM Evenement
            WHERE idActivite = :id
            ORDER BY dateEvenement
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getImagesByActiviteId($id)
    {
        $db = Bdd::getInstance();
        $sql = "
            SELECT chemin
            FROM ImageActivite
            WHERE idActivite = :id
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getAvisByActiviteId($id)
    {
        $db = Bdd::getInstance();
        $sql = "
            SELECT 
                idAvis,
                note,
                commentaire,
                dateAvis
            FROM Avis
            WHERE idActivite = :id
            ORDER BY dateAvis DESC
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStatsAvisByActiviteId($id)
    {
        $db = Bdd::getInstance();
        $sql = "
            SELECT 
                COUNT(*) AS nombreAvis,
                ROUND(AVG(note), 1) AS moyenneAvis
            FROM Avis
            WHERE idActivite = :id
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function getInfoActivity($idClient) {
    $db = Bdd::getInstance();
    $stmt = $db->prepare("
        SELECT 
            a.idActivite, 
            a.titre, 
            a.adresse, 
            a.prix, 
            a.idMeeter, 
            a.tailleGroupe, 
            a.mobiliteReduite,
            i.chemin as image
        FROM Activite a
        LEFT JOIN ImageActivite i ON a.idActivite = i.idActivite 
            AND i.idImageActivite = (
                SELECT MIN(idImageActivite) 
                FROM ImageActivite 
                WHERE idActivite = a.idActivite
            )
        WHERE a.idMeeter = :idClient
    ");
    $stmt->execute([':idClient' => $idClient]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function deleteActivity($idActivite) {
        $db = Bdd::getInstance();

        // 1. Récupérer les chemins des images associées à l'activité
        $images = self::getImagesByActiviteId($idActivite);

        // 2. Supprimer les fichiers images du serveur
        foreach ($images as $imgPath) {
            // Si le chemin n'est pas absolu, adapter le chemin réel du serveur
            $realPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imgPath, '/');
            if (file_exists($realPath)) {
                @unlink($realPath);
            }
        }

        // 3. Supprimer les entrées images en base
        $stmtImg = $db->prepare("DELETE FROM ImageActivite WHERE idActivite = :idActivite");
        $stmtImg->bindParam(':idActivite', $idActivite);
        $stmtImg->execute();

        // 4. Supprimer l'activité
        $stmt = $db->prepare("DELETE FROM Activite WHERE idActivite = :idActivite");
        $stmt->bindParam(':idActivite', $idActivite);
        return $stmt->execute();
    }
}
