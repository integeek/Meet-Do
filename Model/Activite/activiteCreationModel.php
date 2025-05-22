<?php
require_once __DIR__ . '/../Bdd.php';

class ActiviteCreationModel
{
    private static function getDb()
    {
        return Bdd::getInstance();
    }

    public static function getCategories()
    {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT idCategorie, nom FROM Categorie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insererActivite($data, $idMeeter)
    {
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO Activite (titre, description, mobiliteReduite, adresse, dateCreation, tailleGroupe, prix, idMeeter)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['mobiliteReduite'],
            $data['adresse'],
            $data['dateCreation'],
            $data['tailleGroupe'],
            $data['prix'],
            $idMeeter
        ]);
        return $db->lastInsertId();
    }

    public static function getCategoriesByNoms(array $noms)
    {
        $db = self::getDb();
        if (empty($noms)) {
            return [];
        }
        $in  = str_repeat('?,', count($noms) - 1) . '?';
        $stmt = $db->prepare("SELECT idCategorie, nom FROM Categorie WHERE nom IN ($in)");
        $stmt->execute($noms);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function lierCategorieActivite($idActivite, $idCategorie)
    {
        $db = self::getDb();
        $stmt = $db->prepare("INSERT INTO CategorieActivite (idActivite, idCategorie) VALUES (?, ?)");
        $stmt->execute([$idActivite, $idCategorie]);
    }

    public static function ajouterEvenement($idActivite, $date)
    {
        $db = self::getDb();
        $stmt = $db->prepare("INSERT INTO Evenement (idActivite, dateEvenement) VALUES (?, ?)");
        $stmt->execute([$idActivite, $date]);
    }

    public static function ajouterImage($idActivite, $chemin)
    {
        $db = self::getDb();
        error_log("Appel ajouterImage avec idActivite=$idActivite, chemin=$chemin"); // Log l'appel
        try {
            $stmt = $db->prepare("INSERT INTO ImageActivite (chemin, idActivite) VALUES (?, ?)");
            $stmt->execute([$chemin, $idActivite]);
            // Log la requête exécutée (pour affichage côté navigateur)
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('X-SQL-Query: INSERT INTO ImageActivite (chemin, idActivite) VALUES (' . $chemin . ', ' . $idActivite . ')');
            }
        } catch (PDOException $e) {
            error_log('Erreur SQL ajouterImage : ' . $e->getMessage());
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('X-SQL-Error: ' . $e->getMessage());
            }
        }
    }
}
