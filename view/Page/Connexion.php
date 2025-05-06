<?php 
session_start();
$messageErreur = $_SESSION["erreur"] ?? "";
unset($_SESSION["erreur"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" href="../Style/Connexion.css">
</head>
<body>
    <div class="background-image"></div>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>
    <main>
        <div class="parentDiv">
            <div class="containerLogin">
                <h1>Connexion</h1>
                <form action="../../controller/Authentification/Connexion.php" method="post">
                    <p>Email</p>
                    <input class="textbox" type="text" name="email" required>
                    <p>Mot de passe</p>
                    <div id="containerPassword">
                        <input class="textbox" type="password" id="password" name="password" required>
                        <img class="togglePassword" src="../assets/img/ouvert.png" alt="Afficher/Masquer" >
                    </div>
                    <p onclick="openPopUp()">Mot de passe oublié ?</p>
                    <div>
                        <p id="pasCompte">Pas de compte ?</p> <a  id="sinscire" href="Inscription.php">S'inscrire</a>
                    </div>
                    <div class="erreur" style="color: red; margin-bottom: 1rem;">
                        <?= htmlspecialchars($messageErreur) ?>
                    </div>
                    
                    <div id="boutonContainer"></div>
                </form>
                <script src="../component/BoutonBleu.js?v=1.2"></script>
                <script>
                    document.getElementById('boutonContainer').innerHTML = BoutonBleu("Se connecter");
                </script>
            </div>
        </div>
        <div class="popup-overlay" id="popup">
            <div class="popup-content">
                <h1>Mot de passe oublié</h1>
                <p>Insérez votre adresse mail, un lien vous sera adressé par mail pour réinitialiser votre mot de passe</p>
                <form action="../../controller/Authentification/AskResetPass.php" method="post">
                    <p>Email</p>
                    <input class="textbox" type="text" name="emailSend" required>
                    <div class="popup-buttons">
                        <div id="bouton-rouge" onclick="closePopUp()"></div>
                        <div id="bouton-bleue"></div>
                    </div>
                </form>
                <div class="popup-buttons">
                    <script src="../component/BoutonRouge.js"></script>
                    <div id="bouton-rouge" onclick="closePopUp()"></div>
                    <script>
                        document.getElementById('bouton-rouge').innerHTML = BoutonRouge("Annuler");
                    </script>
                    <script>
                        document.getElementById('bouton-bleue').innerHTML = BoutonBleu("Valider");
                    </script>
                </div>
            </div>
        </div>
        <script src="../Script/AfficherPass.js"></script>
        <script src="../Script/PopUp.js"></script>
        <script src="../component/Navbar/Navbar.js"></script>

        <script>
            (async () => {
                document.getElementById('navbar-container').innerHTML = await Navbar("..");
            })();
        </script> 
        <script src="../component/Navbar/navAction.js"></script> 
        
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script> 
    </footer> 
    
</body>
</html>