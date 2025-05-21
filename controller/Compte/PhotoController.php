<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
}

require_once '../../Model/Compte/PhotoModel.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // Centralise ici le chemin d'upload
    $uploadDir = '../../view/assets/uploads/profils/';

    if ($method === 'POST') {
        $idUser = $_SESSION['user']['idClient'] ?? null;
        if (!$idUser) {
            http_response_code(400);
            echo "Utilisateur non identifié.";
            exit;
        }

        // Vérification de l'upload
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (!is_writable($uploadDir)) {
            http_response_code(500);
            echo "Le répertoire de destination n'est pas accessible en écriture.";
            exit;
        }

        $maxFileSize = 5 * 1024 * 1024; // 5 Mo

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo "Aucun fichier envoyé ou erreur lors de l'upload.";
            exit;
        }

        if ($_FILES['photo']['size'] > $maxFileSize) {
            http_response_code(400);
            echo "Le fichier dépasse la taille maximale autorisée.";
            exit;
        }

        // Vérifier s'il existe déjà une photo de profil
        $anciennePhoto = PhotoModel::getPhotoProfil($idUser);
        if ($anciennePhoto) {
            // On vérifie que le chemin n'est pas vide, n'est pas NULL, et que le fichier existe sur le serveur
            $anciennePhotoPath = $anciennePhoto;
            // Si le chemin stocké en BDD est relatif, adapte ici pour obtenir le chemin absolu
            if (!str_starts_with($anciennePhotoPath, '/')) {
                $anciennePhotoPath = $uploadDir . basename($anciennePhotoPath);
            }
            if (file_exists($anciennePhotoPath) && is_file($anciennePhotoPath)) {
                unlink($anciennePhotoPath);
            }
        }

        // Upload de la nouvelle photo
        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $destination = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            PhotoModel::setPhotoProfil($idUser, $destination);
            echo "Photo de profil modifiée avec succès.";
        } else {
            http_response_code(500);
            echo "Erreur lors de l'enregistrement du fichier.";
        }
        exit;
    }

    // GET : retourne le chemin de la photo de profil actuelle
    if ($method === 'GET') {
        $idUser = $_SESSION['user']['idClient'] ?? null;
        if (!$idUser) {
            http_response_code(400);
            echo json_encode(['error' => 'Utilisateur non identifié.']);
            exit;
        }
        $photo = PhotoModel::getPhotoProfil($idUser);
        header('Content-Type: application/json');
        echo json_encode(['photo' => $photo]);
        exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
