<?php 
include_once("../../controller/Activite/mesActivites.php");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../view/Style/mesActivites.css">
  <link rel="stylesheet" href="../../view/component/Navbar/Navbar.css" />
  <link rel="stylesheet" href="../../view/component/Footer/Footer.css" />
  <link rel="stylesheet" href="../../view/component/BoutonBleu.css" />
  <link rel="stylesheet" href="../../view/Style/noReservations.css">
  <link rel="stylesheet" type="text/css" href="../../view/component/BoutonRouge.css">
  <script src="../../view/component/BoutonRouge.js"></script>
  <script src="../../view/component/BoutonBleu.js"></script>
  <title>Mes Activités | Meet&Do</title>
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
        <h1>Mes Activités :</h1>
    </header>
    <main>
      <?php
        function resaComponent($idActivite, $title, $place, $date, $people, $price, $index) {
                    $boutonbleu = "boutonbleu" . $index;
                    $boutonbleu1 = "boutonbleu1" . $index;
                    $boutonrouge = "boutonrouge" . $index;


                    return "
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
                                        document.getElementById('$boutonbleu').onclick = function() {
                                            window.location.href = '../../view/Page/Activite.php?id=$idActivite';
                                        };
                                    </script>
                                    <div id='$boutonbleu1'></div>
                                    <script>
                                        document.getElementById('$boutonbleu1').innerHTML = BoutonBleu(
                                            'Modifier mon activité'
                                        );
                                    </script>
                                    <div id='$boutonrouge' onclick='closePopUp()'></div>
                                    <script>
                                        document.getElementById('$boutonrouge').innerHTML = BoutonRouge('Supprimer mon activité');
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
                    echo "<div class='reservation-list'>";
                    foreach ($reservations as $resa) {
                        echo resaComponent(
                            $resa['idActivite'],
                            $resa['titre'],
                            $resa['adresse'],
                            $resa['dateEvenement'],
                            $resa['nbPlace'],
                            $resa['prix'],
                            $resa['idReservation']
                        );
                    }
                }
      ?>
    </main>
</body>
</html>