<?php
$token = isset($_GET["token"]) ? $_GET["token"] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" href="../Style/NouveauPass.css">
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
        <div class="parentDiv">
            <div class="containerLogin">
                <h1>Nouveau mot de passe</h1>
                <p id="texte">Veuillez insérer un nouveau mot de passe et valider celui-ci</p>
                <form action="../../controller/Authentification/ProcessResetPass.php" method="post">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <p>Nouveau mot de passe</p>
                    <div class="containerPassword">
                        <input class="textbox" type="password" name="pass1" id="password" required>
                        <img class="togglePassword" src="../assets/img/ouvert.png" alt="Afficher/Masquer">
                    </div>
                    <p>Confirmer le nouveau mot de passe</p>
                    <div class="containerPassword">
                        <input class="textbox" type="password" name="pass2" id="password" required>
                        <img class="togglePassword" src="../assets/img/ouvert.png" alt="Afficher/Masquer">
                        <div id="boutonContainer"></div>
                    </div>
                </form>
                <script src="../component/BoutonBleu.js"></script>
                <script>
                    document.getElementById('boutonContainer').innerHTML = BoutonBleu("Confirmer");
                </script>
                <script src="../Script/AfficherPass.js"></script>

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