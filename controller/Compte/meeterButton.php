<?php
session_start();

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/Page/Connexion.php");
    exit;
}

require_once("../../Model/Bdd.php");

$idClient = $_SESSION['user']['id'];
$sql = "SELECT role FROM Client WHERE idClient = :idClient";
$stmt = $db->prepare($sql);
$stmt->execute([':idClient' => $idClient]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
    $role = $result['role'];
} else {
    echo "Erreur : impossible de récupérer le rôle de l'utilisateur.";
    exit;
}

$hideDiv = '';

if($role === 'Meeter' || $role === 'Administrateur') {
    $hideDiv = '<style> .become-meeter {display: none;}</style>';
}

?>