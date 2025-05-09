<?php

session_start();

if (!isset($_SESSION['user']['email'])) {
    header("Location: ../../view/page/Connexion.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/Style/mesReservations.css">
    <link rel="stylesheet" href="../../view/component/Navbar/Navbar.css" />
    <link rel="stylesheet" href="../../view/component/Footer/Footer.css" />
    <link rel="stylesheet" href="../../view/component/BoutonBleu.css" />
    <link rel="stylesheet" href="../../view/Style/noReservations.css">
    <link rel="stylesheet" type="text/css" href="../../view/component/BoutonRouge.css">
    <script src="../../view/component/BoutonBleu.js"></script>
    <script src="../../view/component/BoutonRouge.js"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <div class="navbar-container" id="navbar-container"></div>
        <script src="../../view/component/Navbar/NavbarCompte.js"></script>
        <script>
            document.getElementById("navbar-container").innerHTML = NavbarCompte(
            "../../view"
            );
        </script>
        <h1>Mes Réservations :</h1>
    </header>
    <main>

    
        <?php
            try {
                $db = new PDO(
                    "mysql:host=144.76.54.100;dbname=MeetDo;charset=utf8",
                    "meetndodatabase",
                    "AppG10-D",
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                $email = $_SESSION['user']['email'];
                $sql = "SELECT idClient FROM Client WHERE email = :email";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result && isset($result['idClient'])) {
                    $idClient = $result['idClient'];
                } else {
                    echo "<p>Aucun client trouvé pour l'email $email</p>";
                }


                $stmt =  $db->prepare("
                    SELECT Activite.titre, Activite.adresse, Activite.prix, Evenement.dateEvenement, Reservation.nbPlace, Reservation.idReservation
                    FROM Reservation
                    INNER JOIN Evenement ON Reservation.idEvenement = Evenement.idEvenement
                    INNER JOIN Activite ON Evenement.idActivite = Activite.idActivite
                    WHERE Reservation.idClient = :idClient
                ");

                $stmt->execute([':idClient' => $idClient]);
                $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                function resaComponent($title, $place, $date, $people, $price, $index) {
                    $boutonbleu = "boutonbleu" . $index;
                    $boutonbleu1 = "boutonbleu1" . $index;
                    $boutonrouge = "boutonrouge" . $index;


                    return "
                    <div class='reservation-list'>
                        <div class='reservation-item'>
                            <div class='reservation-item' id='reservation-item-1'>
                                <div class='item-header'>
                                    <h2>$title</h2>
                                <img src='../../view/assets/img/macaron1.jpeg' alt='photo-reservation' class='photo-reservation'>
                                </div>
                                <div class='item-main'>
                                    <div class='item-adresse'>
                                        <img src='../../view/assets/img/icons/position-icon.svg' alt='position-icon'>
                                        <p>$place</p>
                                    </div>
                                    <div class='item-date'>
                                        <img src='../../view/assets/img/icons/calendar.svg' alt='calendar-icon'>
                                        <p>$date</p>
                                    </div>
                                    <div class='item-places'>
                                        <img src='../../view/assets/img/icons/group.svg' alt='group-icon'>
                                        <p>$people</p>
                                    </div>
                                    <div class='item-prix'>
                                        <img src='../../view/assets/img/icons/price.svg' alt='price-icon'>
                                        <p>$price</p>
                                    </div>
                                </div>
                                <div class='item-footer'>
                                    <div id='$boutonbleu'></div>
                                    <script>
                                        document.getElementById('$boutonbleu').innerHTML = BoutonBleu(
                                            'Voir l\'activité'
                                        );
                                    </script>
                                    <div id='$boutonbleu1'></div>
                                    <script>
                                        document.getElementById('$boutonbleu1').innerHTML = BoutonBleu(
                                            'Modifier ma réservation'
                                        );
                                    </script>
                                    <div id='$boutonrouge' onclick='closePopUp()'></div>
                                    <script>
                                        document.getElementById('$boutonrouge').innerHTML = BoutonRouge('Annuler ma réservation');
                                    </script>
                                </div>
                            </div>

                        </div>
                    ";
                }
                    
                if (empty($reservations)) { 
                    include_once '../../view/Page/noReservations.php';
                    exit;
                } else {
                    foreach ($reservations as $resa) {
                        echo resaComponent(
                            $resa['titre'],
                            $resa['adresse'],
                            $resa['dateEvenement'],
                            $resa['nbPlace'],
                            $resa['prix'],
                            $resa['idReservation']
                        );
                    }
                }

            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
            }
        ?>
    </div>
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../../view/component/Footer/Footer.js"></script>
        <script>
            document.getElementById("footer-container").innerHTML = Footer("../../view");
        </script>
    </footer>
</body>
</html>


