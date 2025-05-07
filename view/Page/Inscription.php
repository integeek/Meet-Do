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
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" href="../Style/Inscription.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <div class="background-image"></div>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/Navbar.js"></script>
        <script>
            (async () => {
                document.getElementById('navbar-container').innerHTML = await Navbar("..");
            })();
        </script>
        <script src="../component/Navbar/navAction.js"></script>

    </header>

    <main>
        <div class="containerLogin">
            <h1>Inscription</h1>
            <form action="../../controller/Authentification/Inscription.php" method="post" class="group-form">
                <p>Email</p>
                <input class="textbox" type="text" name="email" required>
                <p>Mot de passe</p>
                <div class="containerPassword">
                    <input class="textbox" type="password" id="password" name="password" required>
                    <img class="togglePassword" src="../assets/img/ouvert.png" alt="Afficher/Masquer" >
                </div> 
                <p>Confirmer le mot de passe</p>
                <div class="containerPassword">
                    <input class="textbox" type="password" id="password2" name="password2" required>
                    <img class="togglePassword" src="../assets/img/ouvert.png" alt="Afficher/Masquer" >
                </div> 
                <div class="validator-criters">
                    <span class="chiffre"><i class="far fa-check-circle"></i> &nbsp;Votre mot de passe doit comporter au moins 1 chiffre</span>
                    <span class="majuscule"><i class="far fa-check-circle"></i> &nbsp;Votre mot de passe doit comporter au moins 1 lettre majuscule</span>
                    <span class="minuscule"><i class="far fa-check-circle"></i> &nbsp;Votre mot de passe doit comporter au moins 1 lettre minuscule</span>
                    <span class="generique"><i class="far fa-check-circle"></i> &nbsp;Votre mot doit comporter au moins 8 caractères</span>
                </div>


                <div class="versCo">
                    <p id="pasCompte">Déjà un compte ?</p> <a id="connexion" href="Connexion.php">Se connecter</a>
                </div>

                <div id="mention">
                    <input type="checkbox" id="mention" name="mention" required/>
                    <div id="mentionTexte"><label id="" for="mention">Je confirme avoir lu et accepté </label><a  id="connexion" href="MentionLegales.html">les conditions générales d'utilisations</a></div>
                </div>
                <div class="erreur" style="color: red; margin-bottom: 1rem;">
                    <?= htmlspecialchars($messageErreur) ?>
                </div>

                <div id="boutonContainer"></div>
            </form>

            <script src="../component/BoutonBleu.js?v=1.2"></script>
            <script>
                document.getElementById('boutonContainer').innerHTML = BoutonBleu("S'inscrire");
            </script>
            <script src="../Script/AfficherPass.js"></script>
        </div>
        <script src="../Script/Inscription.js"></script>

    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>

</body>

</html>