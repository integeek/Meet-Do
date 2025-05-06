<?php
session_start();
require_once '../../controller/Authentification/InfoPerso.php';
$messageErreur = $_SESSION["erreur"] ?? "";
unset($_SESSION["erreur"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos informations</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" href="../Style/InfoPerso.css">
</head>
<body>
    <div class="background-image"></div>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/Navbar.js"></script>
        <script>
            document.getElementById('navbar-container').innerHTML = Navbar(false, "..");
        </script>
        <script src="../component/Navbar/navAction.js"></script> 

    </header>
    <main>
        <div class="containerLogin">
            <h1>Vos informations</h1>
            <form action="" method="post">
                <p>Nom *</p>
                <input class="textbox" type="text" name="nom" required>
                <p>Prénom *</p>
                <input class="textbox" type="text" name="prenom" required>
                <p>Adresse (optionnelle)</p>
                <div id="containerAdresse">
                    <input class="textbox" type="text" name="adresse" id="adresse" required>
                    <img id="iconAdresse" src="../assets/img/pin.png" alt="Adresse" >
                </div>
                <div class="erreur" style="color: red; margin-bottom: 1rem;">
                <?= htmlspecialchars($messageErreur) ?>
                </div>
                <div id="boutonContainer"></div>
            </form>
            <script src="../component/BoutonBleu.js"></script>
            <script>
                document.getElementById('boutonContainer').innerHTML = BoutonBleu("Confirmer");
            </script>

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