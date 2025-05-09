<?php

require_once '../../Model/Bdd.php';

try {
    $pdo = $db;
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        try {
            $stmt = $pdo->prepare("SELECT idCategorie, nom FROM Categorie");
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($categories);
        } catch (Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erreur lors de la récupération des catégories : ' . $e->getMessage()]);
        }
        exit;
    }

    if ($method === 'POST') {
        $titre = $_POST['titre'] ?? '';
        $description = $_POST['description'] ?? '';
        $mobiliteReduite = isset($_POST['mobiliteReduite']) ? 1 : 0;
        $adresse = $_POST['adresse'] ?? '';
        $dates = $_POST['dates'] ?? []; // Tableau de dates soumis par l'utilisateur
        $tailleGroupe = $_POST['tailleGroupe'] ?? 0;
        $prix = $_POST['prix'] ?? 0;
        $themes = isset($_POST['themes']) ? json_decode($_POST['themes'], true) : [];

        // Récupérer dynamiquement l'id du meeter via la session
        session_start();
        $idMeeter = $_SESSION['idMeeter'] ?? 1; // Valeur par défaut si non défini

        if (!$titre || !$description || !$adresse) {
            http_response_code(400);
            echo "Champs requis manquants.";
            exit;
        }

        // Enregistrer l'activité avec la date de création
        $dateCreation = date('Y-m-d H:i:s'); // La date actuelle de la création de l'activité
        $stmt = $pdo->prepare("
            INSERT INTO Activite (titre, description, mobiliteReduite, adresse, dateCreation, tailleGroupe, prix, idMeeter)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$titre, $description, $mobiliteReduite, $adresse, $dateCreation, $tailleGroupe, $prix, $idMeeter]);

        // Récupérer l'ID de l'activité insérée immédiatement après l'insertion
        $idActivite = $pdo->lastInsertId();

        // Récupérer les idCategorie correspondants aux noms des catégories
        $stmt = $pdo->prepare("SELECT idCategorie, nom FROM Categorie WHERE nom IN (?)");
        $stmt->execute([implode(',', $themes)]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Insérer les relations dans CategorieActivite
        $stmt = $pdo->prepare("INSERT INTO CategorieActivite (idActivite, idCategorie) VALUES (?, ?)");
        foreach ($categories as $categorie) {
            $stmt->execute([$idActivite, $categorie['idCategorie']]);
        }

        // Ajouter les événements (dates) dans la table Evenement
        if (!empty($dates)) {
            $stmt = $pdo->prepare("INSERT INTO Evenement (idActivite, dateEvenement) VALUES (?, ?)");
            foreach ($dates as $dateEvenement) {
                $stmt->execute([$idActivite, $dateEvenement]);
            }
        }

        // Gérer l'upload des images
        $uploadDir = '../../view/assets/img/';
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if (is_uploaded_file($tmpName)) {
                $filename = uniqid() . '_' . basename($_FILES['images']['name'][$index]);
                $destination = $uploadDir . $filename;
                move_uploaded_file($tmpName, $destination);

                $stmt = $pdo->prepare("INSERT INTO ImageActivite (chemin, idActivite) VALUES (?, ?)");
                $stmt->execute(["assets/img/$filename", $idActivite]);
            }
        }

        echo "Activité créée avec succès.";
    }
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
