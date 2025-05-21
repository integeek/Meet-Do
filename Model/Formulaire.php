<?php
require_once("Bdd.php");

Class Formulaire {
    public static function create($nom, $prenom, $email, $objet, $message) {
                $db = Bdd::getInstance();
                $sql = "INSERT INTO FormulaireContact (nom, prenom, email, sujet, message, dateEnvoie)
                VALUES (:nom, :prenom, :email, :objet, :message, NOW())";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':objet' => $objet,
                    ':message' => $message
                ]);
            }
}
?>