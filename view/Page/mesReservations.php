<?php 
include_once("../../controller/Reservations/mesReservations.php");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: Connexion');
    exit;
  }
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
    <script src="../../view/Script/PopUp.js" defer></script>
    <title>Mes Réservations | Meet&Do</title>
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
                                            'Modifier ma réservation'
                                        );
                                    </script>
                                    <div id='$boutonrouge'></div>
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

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
                    $cancelConfirmation = $_POST['cancel'];

                    if ($cancelConfirmation === "ANNULER") {
                        $idResa = $_POST['idResa'];
                        Reservation::cancelReservation($idResa);
                        echo "<script>alert('Réservation annulée avec succès.');</script>";
                    } else if ($cancelConfirmation !== "ANNULER") {
                        echo "<script>alert('Erreur lors de l\'annulation de la réservation.');</script>";
                    } else if (empty($cancelConfirmation)) {
                        echo "<script>alert('Veuillez entrer le mot ANNULER pour confirmer.');</script>";
                    }
                }
        ?>
    </div>
    <script>
        window.activite = {idActivite: "<?php echo htmlspecialchars($idActivite, ENT_QUOTES, 'UTF-8'); ?>"};
    </script>
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../../view/component/Footer/Footer.js"></script>
        <script>
            document.getElementById("footer-container").innerHTML = Footer("../../view");
        </script>
    </footer>

    <div class="popup-container" id="edit-lastname-popup">
      <div class="edit-content">
        <div class="edit-header">
          <h3>Modifiez votre Nom</h3>
        </div>
        <form action="../../controller/Compte/ModifierNom.php" method="POST" id="edit-lastname-form">
          <div class="edit-main">
            <input type="text" name="edit-lastname" id="edited-input" />
            <input type="hidden" name="idClient" />
          </div>
          <div class="edit-footer">
            <button type="button" onclick="closePopUp('edit-lastname-popup')" class="buttonRo">Annuler</button>
              <div onclick="document.getElementById('edit-lastname-form').submit()" id="bouton-bleue2"></div>
          <script>
            document.getElementById("bouton-bleue2").innerHTML =
              BoutonBleu("Valider");
          </script>
        </div>
      </form>
    </div>
  </div>

  <div class="popup-container" id="cancel-popup">
      <div class="edit-content">
        <div class="edit-header">
          <h3>Voulez-vous vraiment annuler ?</h3>
        </div>
        <form action="../../view/Page/mesReservations.php" method="POST" id="cancel-form">
          <div class="edit-main">
            <input type="text" name="cancel" id="cancel-input" placeholder="ANNULER" />
            <input type="hidden" name="idResa" value="<?php echo $resa['idReservation'] ?>" />
          </div>
          <div class="edit-footer">
            <button type="button" onclick="closePopUp('cancel-popup')" class="buttonRo">Annuler</button>
              <div onclick="document.getElementById('cancel-form').submit()" id="bouton-bleue3"></div>
          <script>
            document.getElementById("bouton-bleue3").innerHTML =
              BoutonBleu("Valider");
          </script>
        </div>
      </form>
    </div>
  </div>

</body>
</html>