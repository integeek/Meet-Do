<?php
require_once __DIR__ . '/../Bdd.php';

class PhotoModel
{
    private static function getDb()
    {
        return Bdd::getInstance();
    }

    // Récupère le chemin de la photo de profil d'un utilisateur
    public static function getPhotoProfil($idUser)
    {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT photoProfil FROM Client WHERE idClient = ?");
        $stmt->execute([$idUser]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['photoProfil'] : null;
    }

    // Met à jour le chemin de la photo de profil d'un utilisateur
    public static function setPhotoProfil($idUser, $chemin)
    {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE Client SET photoProfil = ? WHERE idClient = ?");
        $stmt->execute([$chemin, $idUser]);
    }
}