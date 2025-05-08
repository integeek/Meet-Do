<?php 

require_once("../../model/Bdd.php");
$idActivite = $_GET['idActivite'] ?? 7;

$sql = "SELECT dateEvenement FROM Evenement WHERE idActivite = :id";
$query = $db->prepare($sql);
$query->bindValue(':id', $idActivite, PDO::PARAM_INT);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_COLUMN);

$datesDisponibles = [];
$horairesList = [];

foreach ($rows as $datetime) {
    $date = date('Y-m-d', strtotime($datetime));
    $heure = date('H:i', strtotime($datetime)) . '-' . date('H:i', strtotime($datetime . ' +1 hour'));

    if (!in_array($date, $datesDisponibles)) {
        $datesDisponibles[] = $date;
    }

    $horairesList[] = [
        'dateEvenement' => $date,
        'heure' => $heure,
        'inscrits' => 0,
        'max' => 10
    ];
}

echo json_encode([
    "datesDisponibles" => $datesDisponibles,
    "horairesParDate" => $horairesList
]);
?>
