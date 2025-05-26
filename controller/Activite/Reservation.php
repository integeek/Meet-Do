<?php 
require_once("../../Model/Reservation.php");
require_once("../../Model/Evenement.php");
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$idClient = $_SESSION['user']['id'] ?? null;

if (!$idClient || !isset($data['date'], $data['heure'], $data['nbPlace'])) {
    echo json_encode(["success" => false, "message" => "Données manquantes ou utilisateur non connecté"]);
    exit;
}

$date = $data["date"];
$heure = $data["heure"];
$nbPlace = intval($data["nbPlace"]);
$isFileAttente = isset($data['fileAttente']) && $data['fileAttente'] === true;

list($heureDebut, ) = explode("-", $heure);

$idEvenement = Evenement::selectEvenement($date, $heureDebut);

if (!$idEvenement) {
    echo json_encode(["success" => false, "message" => "Créneau introuvable"]);
    exit;
}
Reservation::makeReservation($nbPlace, $idClient, $idEvenement,  $isFileAttente ? 1 : 0);
if (!$isFileAttente) {
    $result = Evenement::updatePlacePrise($idEvenement, $nbPlace);
    if (!$result) {
        error_log("Erreur lors de la mise à jour placePrise pour l'événement $idEvenement");
    } else {
        $phrase = "Vous êtes inscrit sur la liste d'attente pour l'activité, vous recevrez un email si une place se libère.";
    }
}

    $destinataire = $_SESSION['user']['email'];
        $sujet = "Confirmation de réservation Meet&Do";
        $message = "<html><body style=\"margin: 0;\">";
        $message .= '
        <style>
            @import url(\'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap\');
        </style>
        <div style="width: 100%; background-color: #004AAD; height: 5rem; display: flex;"><h1 style="margin: auto auto auto auto;  font-family: Inter, sans-serif;">Meet&DO</h1></div>
        <div style="font-family: Inter;">
            <section style="margin: 0 2rem 0 2rem; font-family: Inter;">
                <p style="font-family: Inter;">Bonjour,</p>
                <p style="font-family: Inter;">Nous vous confirmons que vous avez réservé <strong>' . $nbPlace . '</strong> place(s) pour l’activité prévue le <strong>' . $date . '</strong> à <strong>' . $heureDebut . '</strong>.</p>  
                <p style="font-family: Inter;">'. $phrase .'</p>                           
                <p style="font-family: Inter;">Si vos disponibilités changent, n&#39;oubliez pas d&#39;annuler votre réservation depuis votre compte le plus tôt possible.</p>
                <p style="font-family: Inter;">À très vite sur Meet&Do !  </p>
            </section>
            <div style="display: flex; justify-content: center;">
                <div style="width: 40%; border-bottom: 1px solid #64A0FB; margin-top: 2rem; margin-bottom: 2rem;">
                </div>
            </div>
            <section style="margin: 0 auto 0 auto; text-align: center; font-family: Inter;">
                <p style="font-family: Inter;">Notre équipe reste à votre entière disposition pour toute question</p>
                <p style="font-family: Inter;">Tel: +33 6 07 46 76 89 &nbsp; Email: meetanddo@gmail.com</p>
            </section>
            <section style="margin-top: 3rem; font-family: Inter;">
                <h4 style="text-align: center; font-family: Inter;">Restez connecté ! </h4>
                <div style="display: flex; margin: 0 auto 0 auto;">
                    <a style="width: 33%; display: flex; align-items: center; justify-content: center;" href="https://www.facebook.com">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/2023_Facebook_icon.svg/768px-2023_Facebook_icon.svg.png" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                    </a>
                    <a style="width: 33%; display: flex; justify-content: center; align-items: center;" href="https://www.instagram.com">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/960px-Instagram_icon.png" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                    </a> 
                    <a style="width: 33%; display: flex; justify-content: center; align-items: center;" href="https://www.linkedin.com">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuRALyVA0K3z9C2yeZhRpUG7LGbVzLJD8ZmcZReeui69NRx2xonJ3JR5MhTfdFdE-NFSE&usqp=CAU" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                    </a>  
                </div>
            </section>
        </div>
        ';
        $message .= "</body></html>";
        $headers = "From: meetdosav@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

$mailSent = mail($destinataire, $sujet, $message, $headers);


$response = [
    "success" => true,
    "message" => $mailSent ? "Réservation confirmée" : "Réservation effectuée mais problème d'envoi d'email",
    "emailSent" => $mailSent
];

echo json_encode($response);
exit;
?>
