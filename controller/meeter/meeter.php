<?php
require_once('../../model/Bdd.php');

if (!isset($_GET['id'])) {
    die("ID du Meeter manquant.");
}

$meeterId = intval($_GET['id']);

$sqlUser = "SELECT prenom, nom, ville, code_postal, description,
                   YEAR(CURDATE()) - YEAR(date_inscription) AS annee_inscription
            FROM users
            WHERE id = ?";
$stmtUser = $db->prepare($sqlUser);
$stmtUser->execute([$meeterId]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

$sqlActivities = "SELECT a.titre, a.image_path, u.prenom AS organisateur
                  FROM activites a
                  JOIN users u ON a.organisateur_id = u.id
                  WHERE a.organisateur_id = ?";
$stmtActivities = $db->prepare($sqlActivities);
$stmtActivities->execute([$meeterId]);
$activities = $stmtActivities->fetchAll(PDO::FETCH_ASSOC);

$sqlReviews = "SELECT av.note AS rating, av.commentaire, u.prenom AS auteur
               FROM avis av
               JOIN activites a ON av.activite_id = a.id
               JOIN users u ON av.auteur_id = u.id
               WHERE a.organisateur_id = ?";
$stmtReviews = $db->prepare($sqlReviews);
$stmtReviews->execute([$meeterId]);
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

$averageRating = 0;
if (count($reviews) > 0) {
    $totalRating = array_sum(array_column($reviews, 'rating'));
    $averageRating = round($totalRating / count($reviews), 2);
}

$pageData = [
    'user' => $user,
    'activities' => $activities,
    'reviews' => $reviews,
    'averageRating' => $averageRating
];
