<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
  // if (!isset($_SESSION['user'])) {
  //   header('Location: Connexion.php');
  //   exit;
  // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FAQ</title>
  <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
  <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
  <link rel="stylesheet" type="text/css" href="../style/FAQ.css">
  <script src="../Script/Faq.js" defer></script>
  <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css" />
  <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css" />
  <script src="../component/BoutonBleu.js"></script>
  <script src="../component/BoutonRouge.js"></script>
  <script src="../Script/FAQ.js" defer></script>
  <script src="../Script/PopUp.js" defer></script>
</head>

<body>
  <header>
    <div id="navbar-container" class="navbar-container"></div>
    <script src="../component/Navbar/Navbar.js"></script>
    <script>
    (async () => {
        document.getElementById('navbar-container').innerHTML = await Navbar("..");
        if (!window.navActionLoaded) {
            const script = document.createElement('script');
            script.src = "../component/Navbar/navAction.js";
            script.onload = () => {
                window.navActionLoaded = true;
                window.initializeNavbar();
            };
            document.body.appendChild(script);
        } else {
            window.initializeNavbar();
        }
    })();
</script>

  </header>
  <main>
    <h1 id="title">FAQ</h1>
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
          <div class="alert">
            <?php if (isset($_SESSION['success'])): ?>
              <p class="success"><?php echo $_SESSION['success']; ?></p>
              <?php unset($_SESSION['success']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
              <p class="error"><?php echo $_SESSION['error']; ?></p>
              <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>
    <div style="display: flex;">
      <div id="select-div">
        <select id="select"></select>
      </div>
      <div class="grow"></div>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "Administrateur"): ?>
        <button type="button" id="new-question-button" onclick="openPopUp('add-question-popup')">
          <p>Ajouter une question</p>
          <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
        </button>
      <?php endif; ?>
    </div>
    </div>
    <div class="collapse-container"></div>

    <div class="popup-container" id="add-question-popup">
      <div class="popup-content">
        <div class="popup-header">
        <h1>Ajouter un question</h1>
        </div>
        <div class="popup-main">
        <form action="../../controller/Faq/FaqControlleur.php?action=addQuestion" method="POST" id="add-question-form">
        <div class="theme">
            <label for="theme">Sélectionner un thème :</label>
            <select id="theme" name="theme">
              <option value="1">Comptes</option>
              <option value="2">Réservations</option>
              <option value="3">Règlements</option>
              <option value="4">Bugs</option>
            </select>
          </div>
          <div class="question">
            <input type="text" name="question" id="question1" placeholder="Entrez une question" />
          </div>
          <div class="reponse">
            <textarea id="reponse1" name="reponse" placeholder="Entrez une réponse" rows="4" cols="50"></textarea>
          </div>
        </div>
        <div class="popup-footer">
        <div id="bouton-rouge1" onclick="closePopUp('add-question-popup')"></div>
          <script>
            document.getElementById("bouton-rouge1").innerHTML =
              BoutonRouge("Annuler");
          </script>
          <div onclick="document.getElementById('add-question-form').submit()" id="bouton-bleue1"></div>
          <script>
            document.getElementById("bouton-bleue1").innerHTML =
              BoutonBleu("Valider");
          </script>
        </form>
        </div>
      </div>
    </div>
  </main>
  <footer id="footer-container" class="footer-container">
    <script src="../component/Footer/Footer.js"></script>
    <script>
      document.getElementById('footer-container').innerHTML = Footer("..");
    </script>

  </footer>
</body>

</html>