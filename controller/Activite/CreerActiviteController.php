<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
} elseif ($_SESSION['user']['role'] !== "Administrateur" && $_SESSION['user']['role'] !== "Meeter") {
    $_SESSION['erreur'] = "Vous n'avez pas les droits d'accès à cette page.";
    header('Location: ../../view/Page/accueil.php');
    exit;
}

require_once '../../Model/Activite/activiteCreationModel.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        try {
            $categories = ActiviteCreationModel::getCategories();
            header('Content-Type: application/json');
            echo json_encode($categories);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération des catégories : ' . $e->getMessage()]);
        }
        exit;
    }

    if ($method === 'POST') {
        $titre = $_POST['titre'] ?? '';
        $description = $_POST['description'] ?? '';
        $mobiliteReduite = isset($_POST['mobiliteReduite']) ? 1 : 0;
        $adresse = $_POST['adresse'] ?? '';
        $dates = $_POST['dates'] ?? [];
        $tailleGroupe = $_POST['tailleGroupe'] ?? 0;
        $prix = $_POST['prix'] ?? 0;
        $themes = isset($_POST['themes']) ? json_decode($_POST['themes'], true) : [];

        $idMeeter = $_SESSION['user']['idClient'] ?? 4;

        if (!$titre || !$description || !$adresse || !$idMeeter) {
            http_response_code(400);
            echo "Champs requis manquants.";
            exit;
        }

        $data = [
            'titre' => $titre,
            'description' => $description,
            'mobiliteReduite' => $mobiliteReduite,
            'adresse' => $adresse,
            'dateCreation' => date('Y-m-d H:i:s'),
            'tailleGroupe' => $tailleGroupe,
            'prix' => $prix
        ];

        $idActivite = ActiviteCreationModel::insererActivite($data, $idMeeter);

        // Catégories
        $categories = ActiviteCreationModel::getCategoriesByNoms($themes);
        foreach ($categories as $categorie) {
            ActiviteCreationModel::lierCategorieActivite($idActivite, $categorie['idCategorie']);
        }

        // Dates
        foreach ($dates as $date) {
            ActiviteCreationModel::ajouterEvenement($idActivite, $date);
        }

        // Upload des images
        $uploadDir = '../../view/assets/img/';
        if (isset($_FILES['images'])) {
            $files = $_FILES['images'];
            error_log('$_FILES : ' . print_r($_FILES, true));
            // Si plusieurs fichiers
            if (is_array($files['name'])) {
                $fileCount = count($files['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if (!empty($files['tmp_name'][$i]) && is_uploaded_file($files['tmp_name'][$i])) {
                        $filename = uniqid() . '_' . basename($files['name'][$i]);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                            ActiviteCreationModel::ajouterImage($idActivite, "../assets/img/$filename");
                        }
                    }
                }
            } else {
                // Cas d'un seul fichier
                if (!empty($files['tmp_name']) && is_uploaded_file($files['tmp_name'])) {
                    $filename = uniqid() . '_' . basename($files['name']);
                    $destination = $uploadDir . $filename;
                    if (move_uploaded_file($files['tmp_name'], $destination)) {
                        ActiviteCreationModel::ajouterImage($idActivite, "../assets/img/$filename");
                    }
                }
            }
        }

        echo "Activité créée avec succès.";
    }
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
