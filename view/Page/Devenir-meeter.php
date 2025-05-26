<?php 
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: Connexion');
    exit;
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
    <link rel="stylesheet" href="../Style/Devenir-meeter.css" />
    <link rel="stylesheet" href="../component/Navbar/Navbar.css" />
    <link rel="stylesheet" href="../component/Footer/Footer.css" />
    <link rel="stylesheet" href="../component/BoutonBleu.css" />
    <title>Devenir meeter</title>
  </head>
  <body>
    <header>
      <div class="navbar-container" id="navbar-container"></div>
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
      <h1>Demande pour devenir Meeter</h1>
    </header>
    <main>
      <div class="add-photo-container">
        <h2>Photo de profil :*</h2>
        <div class="add-photo">
          <script src="../component/BoutonBleu.js"></script>
          <div id="boutonContainer1"></div>
          <script>
            document.getElementById("boutonContainer1").innerHTML = BoutonBleu(
              "Ajouter votre photo de profil"
            );
          </script>
          <img
            src="../assets/img/icons/profile-icon.svg"
            alt="profile-icon"
            id="profile-icon"
          />
        </div>
      </div>
      <h2>Adresse :*</h2>
      <form action="../../controller/Compte/formMeeter.php" method="POST" id="form-meeter">
      <div class="adress-container">
        <div class="input-adress">
          <input
            type="text"
            name="adresse-meeter"
            id="address"
            placeholder="Entrez votre adresse postale"
            required />
          <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
        </div>
      </div>
      <div class="description">
        <h2>Description de vous-même :*</h2>
        <textarea
          id="description-area"
          rows="10"
          name="description-meeter"
          placeholder="Descrivez-vous en quelques mots..."
          required ></textarea>
        <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
      </div>
      <div class="telephone-container">
        <h2>Numéro de téléphone :*</h2>
        <div class="input-telephone">
          <input type="tel" name="telephone-meeter" pattern="^0[1-9]\d{8}$" id="telephone" placeholder="Entrez votre numéro" required/>
          <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
        </div>
      </div>
      <div class="age-verif-container">
        <div class="age">
          <p>Certifiez-vous d'avoir 18 ans ou plus ?*</p>
          <input type="checkbox" id="checkbox-age" required/>
          <input type="hidden" name="idClient" value="<?php echo $idClient; ?>" />
        </div>
        <div id="boutonContainer3"></div>
        <script>
          document.getElementById("boutonContainer3").innerHTML =
            BoutonBleu("Devenir Meeter");
        </script>
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
      </div>
      </form>
      <script src="../component/Navbar/navAction.js"></script>
    </main>
    <footer id="footer-container" class="footer-container">
      <script src="../component/Footer/Footer.js"></script>
      <script>
        document.getElementById("footer-container").innerHTML = Footer("..");
      </script>
    </footer>
  </body>
</html>
