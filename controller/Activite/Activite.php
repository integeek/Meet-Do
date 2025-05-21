<?php 
require_once("../../Model/Evenement.php");

$idActivite = $_GET['idActivite'] ?? 7;

$rows = Evenement::selectDateEvenement($idActivite);

$datesDisponibles = [];
$horairesList = [];

foreach ($rows as $row) {
    $datetime = $row['dateEvenement'];
    $date = date('Y-m-d', strtotime($datetime));
    $heure = date('H:i', strtotime($datetime)) . '-' . date('H:i', strtotime($datetime . ' +1 hour'));

    if (!in_array($date, $datesDisponibles)) {
        $datesDisponibles[] = $date;
    }

    $horairesList[] = [
        'dateEvenement' => $date,
        'heure' => $heure,
        'inscrits' => (int)($row['placePrise'] ?? 0),
        'max' => 10
    ];
}

echo json_encode([
    "datesDisponibles" => $datesDisponibles,
    "horairesParDate" => $horairesList
]);
?>
