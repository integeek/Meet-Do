<?php
require_once("Bdd.php");

Class Client {
    public static function checkEmail($email) {
        $db = Bdd::getInstance();
        $sql = $db -> prepare("SELECT idClient FROM Client WHERE email = :email");
        $sql-> bindValue(":email", $email, PDO::PARAM_STR);
        $sql->execute();
        return $sql->fetch();
    }
    public static function createUser($cle, $email, $pass, $expiricy) {
        $db = Bdd::getInstance();
        $sql = "INSERT INTO user (cle, email, password, token_expires_at) VALUES ('$cle', :email, '$pass', '$expiricy')";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
        ]);
        return $db->lastInsertId();
    }

    public static function recupUser( $getid, $getcle) {
        $db = Bdd::getInstance();
        $sql = $db->prepare("SELECT id, email, password FROM user WHERE id = :id AND cle = :cle");
        $sql->bindValue(":id", $getid, PDO::PARAM_INT);
        $sql->bindValue(":cle", $getcle, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch();
    }

    public static function insertUser($email, $password, $nom, $prenom, $adresse) {
        $db = Bdd::getInstance();
        $sql = "INSERT INTO Client (email, password, nom, prenom, localisation) VALUES (:email, :password, :nom, :prenom, :adresse)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':adresse' => $adresse
        ]);
        return $db->lastInsertId();
    }

    public static function connexion($email) {
        $db = Bdd::getInstance();
        $sql = "SELECT * FROM Client WHERE email = :email";
        $query = $db -> prepare($sql);
        $query -> bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query -> execute();
        return $query -> fetch();
    }

    public static function generateResetToken($email, $expiricy) {
        $db = Bdd::getInstance();
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $sql = "UPDATE Client SET reset_token_hash = :reset_token, reset_token_expires_at= :reset_expires WHERE email = :email";
            $query = $db -> prepare($sql);
        $query->execute([
            "email" => $email,
            "reset_token" => $token_hash,
            "reset_expires" => $expiricy
        ]);
        
        if ($query->rowCount() > 0) {
            return $token;
        }
        return false;
    }

    public static function getUserByResetToken($token_hash) {
        $db = Bdd::getInstance();
        $sql = "SELECT * FROM Client WHERE reset_token_hash = :reset_token";
        $query = $db -> prepare($sql);
        $query->execute([
        "reset_token" => $token_hash,
        ]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function resetPassword($password, $id) {
        $db = Bdd::getInstance();
        $sql = "UPDATE Client SET password= :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE idClient=:id";
        $query = $db -> prepare($sql);
        $query->execute([
                    "password" => $password,
                    "id" => $id,
                ]);
    }
}

?>