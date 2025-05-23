<?php
include("../../controller/Compte/meeterButton.php");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
  }
}

$prenom = $_SESSION['user']['prenom'];
$nom = $_SESSION['user']['nom'];
$email = $_SESSION['user']['email'];
$idClient = $_SESSION['user']['id'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Style/PageCompte.css" />
  <link rel="stylesheet" href="../component/Navbar/Navbar.css" />
  <link rel="stylesheet" href="../component/Footer/Footer.css" />
  <link rel="stylesheet" href="../component/BoutonBleu.css" />
  <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css" />
  <script src="../component/BoutonBleu.js"></script>
  <script src="../component/BoutonRouge.js"></script>
  <script src="../Script/PopUp.js" defer></script>
  <title>Mon Compte | Meet&Do</title>
</head>

<body>
  <header>
    <div class="navbar-container" id="navbar-container"></div>
    <script src="../component/Navbar/NavbarCompte.js"></script>
    <script>
      (async () => {
        document.getElementById('navbar-container').innerHTML = await NavbarCompte("../../view");
      })();
    </script>
    <h1>Mes Informations :</h1>
  </header>
  <main>
    <div class="global-container">
      <div class="infos-container">
        <div class="profile-container">
          <img src="../assets/img/icons/profile-icon.svg" alt="profile-icon" id="profile-icon" />
          <div id="boutonContainer"></div>
          <script>
            document.getElementById("boutonContainer").innerHTML = BoutonBleu(
              "Modifier photo de profil"
            );
            // Affichage dynamique de la photo de profil
            fetch('../../controller/Compte/PhotoController.php', { method: 'GET' })
              .then(response => response.json())
              .then(data => {
                if (data.photo && data.photo !== "") {
                  document.getElementById('profile-icon').src = data.photo;
                }
              });
          </script>
        </div>
        <hr>
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
        <form>
          <div class="firstname-container">
            <div class="input-firstname">
              <label for="firstname">Prénom :</label>
              <input type="text" id="firstname" value="<?php echo $prenom; ?>" readonly />
            </div>
            <img src="../assets/img/icons/edit-icon.svg" alt="edit-icon" class="edit-icon"
              onclick="openPopUp('edit-firstname-popup')" />
          </div>
          <div class="lastname-container">
            <div class="input-lastname">
              <label for="lastname">Nom :</label>
              <input type="text" id="lastname" value="<?php echo $nom; ?>" readonly />
            </div>
            <img src="../assets/img/icons/edit-icon.svg" alt="edit-icon" class="edit-icon"
              onclick="openPopUp('edit-lastname-popup')" />
          </div>
          <div class="email-container">
            <div class="input-email">
              <label for="email">Email :</label>
              <input type="email" id="email" value="<?php echo $email; ?>" readonly />
            </div>
            <!-- <img src="../assets/img/icons/edit-icon.svg" alt="edit-icon" class="edit-icon" onclick="openPopUp('edit-email-popup')"/> -->
          </div>
          <div class="password-container">
            <div class="input-password">
              <label for="password">Mot de passe :</label>
              <input type="password" id="password" value="Mot de passe" readonly />
            </div>
            <img src="../assets/img/icons/edit-icon.svg" alt="edit-icon" class="edit-icon" id="editIcon">
          </div>

          <script>
             const UpdateClient = () => {

              const email = "<?php echo $_SESSION['user']['email']; ?>";

                var request = new XMLHttpRequest();
                request.open("POST", `../../controller/Authentification/AskResetPass.php`, true);
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                const body = new URLSearchParams({ emailSend: email }).toString();
                request.send(body);
              };

            console.log('test')
            const editIcon = document.getElementById('editIcon');
            console.log(editIcon);
            editIcon.addEventListener('click', function () {
              console.log('Edit icon clicked');
              alert('Un mail pour changer votre mot de passe a été envoyé à votre adresse email.');
              UpdateClient();
            });
          </script>

        </form>
      </div>
      <div class="become-meeter">
        <?php echo $hideDiv ?>
        <h2>Devenir meeter</h2>
        <div class="meeter-container">
          <p>
            Vous souhaitez organiser vos propres activités ? Devenez un meeter
            maintenant.
          </p>
          <a href="../../view/Page/Devenir-meeter.php">
            <div id="boutonContainer1"></div>
          </a>
          <script>
            document.getElementById("boutonContainer1").innerHTML = BoutonBleu(
              "Devenir Meeter !"
            );
          </script>
        </div>
      </div>
    </div>
  </main>
  <footer id="footer-container" class="footer-container"></footer>
  <script src="../component/Footer/Footer.js"></script>
  <script>
    document.getElementById('footer-container').innerHTML = Footer("..");
  </script>

  <div class="edit-container" id="edit-firstname-popup">
    <div class="edit-content">
      <div class="edit-header">
        <h3>Modifiez votre Prénom</h3>
      </div>
      <form action="../../controller/Compte/ModifierPrenom.php" method="POST" id="edit-firstname-form">
        <div class="edit-main">
          <input type="text" name="edit-firstname" id="edited-input" placeholder="<?php echo $prenom; ?>" />
          <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
        </div>
        <div class="edit-footer">
          <button type="button" onclick="closePopUp('edit-firstname-popup')" class="buttonRo">Annuler</button>
          <div onclick="document.getElementById('edit-firstname-form').submit()" id="bouton-bleue1"></div>
          <script>
            document.getElementById("bouton-bleue1").innerHTML =
              BoutonBleu("Valider");
          </script>
        </div>
      </form>
    </div>
  </div>

  <div class="edit-container" id="edit-lastname-popup">
    <div class="edit-content">
      <div class="edit-header">
        <h3>Modifiez votre Nom</h3>
      </div>
      <form action="../../controller/Compte/ModifierNom.php" method="POST" id="edit-lastname-form">
        <div class="edit-main">
          <input type="text" name="edit-lastname" id="edited-input" placeholder="<?php echo $nom; ?>" />
          <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
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

  <div class="edit-container" id="edit-email-popup">
    <div class="edit-content">
      <div class="edit-header">
        <h3>Modifiez votre Email</h3>
      </div>
      <div class="edit-main">
        <input type="text" id="edited-input" placeholder="<?php echo $email; ?>" />
      </div>
      <div class="edit-footer">
        <div id="bouton-rouge3" onclick="closePopUp('edit-email-popup')"></div>
        <script>
          document.getElementById("bouton-rouge3").innerHTML =
            BoutonRouge("Annuler");
        </script>
        <div id="bouton-bleue3"></div>
        <script>
          document.getElementById("bouton-bleue3").innerHTML =
            BoutonBleu("Valider");
        </script>
      </div>
    </div>
  </div>

  <div class="edit-container" id="edit-photo-popup" style="display:none;">
    <div class="edit-content">
      <div class="edit-header">
        <h3>Changer la photo de profil</h3>
      </div>
      <form id="edit-photo-form" enctype="multipart/form-data">
        <div class="edit-main">
          <input type="file" name="photo" id="input-pdp" accept="image/*" required />
        </div>
        <div class="edit-footer">
          <button type="button" onclick="closePopUp('edit-photo-popup')" class="buttonRo">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  // Ouvre le pop-up à l'ouverture du bouton
  document.getElementById("boutonContainer").onclick = function () {
    openPopUp('edit-photo-popup');
  };

  // Upload automatique dès qu'un fichier est choisi
  document.getElementById("input-pdp").addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append("photo", file);

    fetch("../../controller/Compte/PhotoController.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then(() => {
        closePopUp('edit-photo-popup');
        window.location.reload();
      })
      .catch(() => {
        alert("Erreur lors de l'upload de la photo.");
        closePopUp('edit-photo-popup');
        window.location.reload();
      });
  });
</script>

</body>

</html>