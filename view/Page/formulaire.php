<?php 
session_start();
$messageErreur = $_SESSION["erreur_contact"] ?? "";
unset($_SESSION["erreur_contact"]);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous contacter</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../Style/Formulaire.css">
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

    <div class="container">
        <div class="contact">
            <h2>Contactez-nous</h2>
            <div class="contact-info">
                <p><img src="../assets/img/pin.png" alt="Adresse"> 28 rue Notre Dame des Champs, 75006 Paris</p>
                <p><img src="../assets/img/telephone.png" alt="Téléphone"> +33 06 06 06 06 06</p>
                <p><img src="../assets/img/icons/icon-mail.svg" alt="Email"> meetdosav@gmail.com</p>
            </div>
            <div class="social-icons">
                <img src="../assets/img/b.webp" alt="Facebook">
                <img src="../assets/img/twitter-x-new-logo-symbol-png-11692479881mg8srkkgy5.webp" alt="Twitter">
                <img src="../assets/img/png-transparent-icon-essential-instagram-2016-app-logo-vector-images-social-networks.png" alt="Instagram">
                <img src="../assets/img/a.png" alt="LinkedIn">
            </div>
        </div>

        <div class="forume">
            <h2>Formulaire</h2>
            <form action="../../controller/formulaire/formulaire.php" method="post">
                <div class="form-row">
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="objet" placeholder="Objet" required>
                </div>
                <div class="form-group">
                    <textarea name="message" rows="4" placeholder="Message" required></textarea>
                <div class="erreur"><?= htmlspecialchars($messageErreur) ?></div>
                <div id="boutonContainer"></div>
                </div>
            </form>
            <script src="../component/BoutonBleu.js?v=1.2"></script>
            <script>
                document.getElementById('boutonContainer').innerHTML = BoutonBleu("Envoyer");
            </script>
        </div>
    </div>

    <footer id="footer-container" class="footer-container"></footer>
    <script src="../component/Footer/Footer.js"></script>
    <script>
        document.getElementById('footer-container').innerHTML = Footer("..");
    </script>
</body>
</html>
