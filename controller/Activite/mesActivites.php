<?php
session_start();
require_once("../../Model/Activite/activiteModel.php");

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion");
    exit;
}

$idClient = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

if ($role !== 'Meeter' && $role !== 'Administrateur') {
    $_SESSION['error'] = "Vous n'avez pas accès à cette page.";
    header("Location: ../../view/Page/Devenir-meeter");
    exit;
}

$activites = activiteModel::getInfoActivity($idClient);
?>