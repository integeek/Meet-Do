<?php 
include_once("../../controller/Activite/mesActivites.php");

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
  <link rel="stylesheet" href="../../view/Style/mesActivites.css">
  <link rel="stylesheet" href="../../view/component/Navbar/Navbar.css" />
  <link rel="stylesheet" href="../../view/component/Footer/Footer.css" />
  <link rel="stylesheet" href="../../view/component/BoutonBleu.css" />
  <link rel="stylesheet" href="../../view/Style/noActivites.css">
  <link rel="stylesheet" href="../../view/component/BoutonRouge.css">
  <script src="../../view/component/BoutonRouge.js"></script>
  <script src="../../view/component/BoutonBleu.js"></script>
  <script src="../../view/Script/PopUp.js" defer></script>
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
        function resaComponent($idActivite, $title, $place, $people, $price, $mR, $image) {
                    $boutonbleu = "boutonbleu" . $idActivite;
                    $boutonbleu1 = "boutonbleu1" . $idActivite;
                    $boutonrouge = "boutonrouge" . $idActivite;

                    $imageUrl = $image ? $image : '../../view/assets/img/placeholder.png';

                    return "
                        <div class='reservation-item'>
                            <div class='reservation-item' id='reservation-item-1'>
                                <div class='item-header'>
                                    <h2>$title</h2>
                                    <img src='$imageUrl' alt='$title' class='photo-reservation'>
                                </div>
                                <div class='item-main'>
                                    <div class='item-adresse'>
                                        <img src='../../view/assets/img/icons/position-icon.svg' alt='position-icon'>
                                        <p>$place</p>
                                    </div>
                                    <div class='item-date'>
                                        <img src='../../view/assets/img/icons/pmr-icon.svg' alt='pmr-icon'>
                                        <p>$mR</p>
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
                                    <a href='../../view/Page/ListeEvenement.php?idActivite=$idActivite' class='button-event'>
                                      Voir l'activité
                                    </a>
                                </div>
                            </div>

                        </div>
                    ";
                }

                if (empty($activites)) { 
                    include_once '../../view/Page/noActivites.php';
                    exit;
                } else {
                    echo "<div class='reservation-list'>";
                    foreach ($activites as $acti) {
                        echo resaComponent(
                            $acti['idActivite'],
                            $acti['titre'],
                            $acti['adresse'],
                            $acti['tailleGroupe'],
                            $acti['prix'],
                            $acti['mobiliteReduite'],
                            $acti['image']
                  
                        );
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                    $deleteConfirmation = $_POST['delete'];

                    if ($deleteConfirmation === "SUPPRIMER") {
                        $idActivite = $_POST['idActivite'];
                        activiteModel::deleteActivity($idActivite);
                        echo "<script>alert('L\'activité a été supprimé avec succès.');</script>";
                    } else if ($deleteConfirmation !== "SUPPRIMER") {
                        echo "<script>alert('Erreur lors de la suppression de l\'activité.');</script>";
                    } else if (empty($deleteConfirmation)) {
                        echo "<script>alert('Veuillez entrer le mot SUPPRIMER pour confirmer.');</script>";
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

    <div class="popup-container" id="edit-activity">
      <div class="edit-content">
        <div class="edit-header">
          <h3>Modifiez votre Nom</h3>
        </div>
        <form action="../../controller/Compte/ModifierNom.php" method="POST" id="edit-activity-form">
          <div class="edit-main">
            <input type="text" name="edit-lastname" id="edited-input" />
            <input type="hidden" name="idClient" />
          </div>
          <div class="edit-footer">
            <button type="button" onclick="closePopUp('edit-activity')" class="buttonRo">Annuler</button>
              <div onclick="document.getElementById('edit-activity-form').submit()" id="bouton-bleue2"></div>
          <script>
            document.getElementById("bouton-bleue2").innerHTML =
              BoutonBleu("Valider");
          </script>
        </div>
      </form>
    </div>
  </div>

  <div class="popup-container" id="delete-popup">
      <div class="edit-content">
        <div class="edit-header">
          <h3>Voulez-vous vraiment supprimer ?</h3>
        </div>
        <form action="../../view/Page/mesActivites.php" method="POST" id="delete-form">
          <div class="edit-main">
            <input type="text" name="delete" id="delete-input" placeholder="SUPPRIMER" />
            <input type="hidden" name="idActivite" value="<?php echo $acti['idActivite'] ?>" />
          </div>
          <div class="edit-footer">
            <button type="button" onclick="closePopUp('delete-popup')" class="buttonRo">Annuler</button>
              <div onclick="document.getElementById('delete-form').submit()" id="bouton-bleue3"></div>
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