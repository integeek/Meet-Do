<?php 
session_start();
$messageErreur = $_SESSION["erreur"] ?? "";
unset($_SESSION["erreur"]);
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
      })();
    </script>
    <script src="../component/navAction.js"></script>

  </header>
  <main>
    <h1 id="title">FAQ</h1>
    <div style="display: flex;">
      <div id="select-div">
        <select id="select"></select>
      </div>
      <div class="grow"></div>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "Administrateur"): ?>
        <button type="button" id="new-question-button" onclick="openPopUp('add-question-popup')">
          <p>Ajouter une question</p>
          <img src="../assets/img/mes sage.png" alt="message icon" id="message-icon" />
        </button>
      <?php endif; ?>
<!-- 
      <button type="button" id="new-question-button" onclick="openPopUp('add-question-popup')">
        <p>Ajouter une question</p>
        <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
      </button> -->

    </div>
    </div>
    <div class="collapse-container"></div>

    <div class="popup-container" id="add-question-popup">
      <div class="popup-content">
        <div class="popup-header">
        <h1>Ajouter un question</h1>
        </div>
        <div class="popup-main">
        <div class="theme">
            <label for="theme">Sélectionner un thème :</label>
            <select id="theme" name="theme">
              <option value="theme1">Thème 1</option>
              <option value="theme2">Thème 2</option>
              <option value="theme3">Thème 3</option>
            </select>
          </div>
          <div class="question">
            <input type="text" id="question1" placeholder="Entrez une question" />
          </div>
          <div class="reponse">
            <textarea id="reponse1" placeholder="Entrez une réponse" rows="4" cols="50"></textarea>
          </div>
        </div>
        <div class="popup-footer">
        <div id="bouton-rouge1" onclick="closePopUp('add-question-popup')"></div>
          <script>
            document.getElementById("bouton-rouge1").innerHTML =
              BoutonRouge("Annuler");
          </script>
          <div id="bouton-bleue1"></div>
          <script>
            document.getElementById("bouton-bleue1").innerHTML =
              BoutonBleu("Valider");
          </script>
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