<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if(!isset($_SESSION['user'])) {
    header('Location: Connexion');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Style/noReservations.css">
  <link rel="stylesheet" href="../component/Navbar/Navbar.css" />
  <link rel="stylesheet" href="../component/Footer/Footer.css" />
  <link rel="stylesheet" href="../component/BoutonBleu.css" />
  <title>Mes Réservations | Meet&Do</title>
</head>

<body>
  <main>
    <img src="../../view/assets/img/icons/warning-icon.svg" alt="warning-icon" id="warning-icon" />
    <h2 id="warning-text">Aucune réservation trouvée.</h2>
    <p id="warning-subtext">Vous n'avez pas encore de réservation.</p>
    <script src="../component/BoutonBleu.js"></script>
    <div id="boutonContainer1"></div>
    <script>
      document.getElementById("boutonContainer1").innerHTML = BoutonBleu(
        "Voir les activités disponibles"
      );
    </script>
  </main>
  <footer id="footer-container" class="footer-container">
    <script src="../../view/component/Footer/Footer.js"></script>
    <script>
      document.getElementById("footer-container").innerHTML = Footer("../../view");
    </script>
  </footer>
</body>

</html>