<?php
require_once '../../model/Bdd.php'; 

$idClient = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupération des infos du Client
$stmt = $db->prepare("
    SELECT nom, prenom, localisation, photoProfil, description
    FROM Client
    WHERE idClient = :id
");
$stmt->execute([':id' => $idClient]);
$profil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profil) {
    die("Profil introuvable.");
}


$pageData = [
    'nom' => $profil['nom'],
    'prenom' => $profil['prenom'],
    'localisation' => $profil['localisation'],
    'photoProfil' => $profil['photoProfil'],
    'description' => $profil['description'] ?? "Ce profil n'a pas encore ajouté de description.",
    'anciennete' => 'Non renseignée', 
];


$stmtAct = $db->prepare("
    SELECT a.idActivite, a.titre, a.description, ia.chemin AS image
    FROM Activite a
    LEFT JOIN ImageActivite ia ON a.idActivite = ia.idActivite
    WHERE a.idMeeter = :id AND a.isVisible = 1
");
$stmtAct->execute([':id' => $idClient]);
$pageData['activites'] = $stmtAct->fetchAll(PDO::FETCH_ASSOC);

// Avis sur ses activités
$stmtAvis = $db->prepare("
    SELECT c.prenom, c.nom, av.note, av.commentaire
    FROM Avis av
    JOIN Client c ON av.idClient = c.idClient
    JOIN Activite a ON av.idActivite = a.idActivite
    WHERE a.idMeeter = :id
");
$stmtAvis->execute([':id' => $idClient]);
$avisList = $stmtAvis->fetchAll(PDO::FETCH_ASSOC);

$pageData['avis'] = [];
$noteTotale = 0;

foreach ($avisList as $avis) {
    $pageData['avis'][] = [
        'auteur' => $avis['prenom'] . ' ' . $avis['nom'],
        'note' => $avis['note'],
        'commentaire' => $avis['commentaire']
    ];
    $noteTotale += $avis['note'];
}

$pageData['moyenneAvis'] = count($avisList) > 0 ? round($noteTotale / count($avisList), 1) : null;

include '../../view/pageMeeter.php'; 
