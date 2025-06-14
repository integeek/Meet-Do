<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales | Meet & Do</title>

    <!-- Font + icons -->
    <link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../Style/MentionLegales.css">
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

    <!-- CONTENU -->
    <main class="container">
        <h1>MENTIONS LÉGALES</h1>
        <p>Conformément aux dispositions de la loi n° 2004-575 du 21 juin 2004 pour la confiance en l'économie numérique, il est précisé aux utilisateurs du site Meet&Do l'identité des différents intervenants dans le cadre de sa réalisation et de son suivi.
        </p>

        <h2>Édition du site</h2>
        <p>Le présent site, accessible à l’URL www.meetdo.fr (le « Site »), est édité par :</p>
        <p>Antoine Latour, résidant 10 rue de vanves 92130 ISSY-LES-MOULINEAUX, de nationalité Française (France)</p>

        <h2>Hébergement</h2>
        <p>Le site est hébergé par la société GarageIsep, situé 10 r Vanves, 92130 Issy les Moulineaux, (contact
            téléphonique ou email : bureau@garageisep.com).</p>

        <h2>Directeur de publication</h2>
        <p>Le Directeur de la publication du Site est Antoine LATOUR.</p>

        <h2>Nous contacter</h2>
        <p>Par téléphone : +33606060606</p>
        <p>Par email : meetdosav@gmail.com</p>
        <p>Par courrier : 10 rue de vanves 92130 ISSY-LES-MOULINEAUX</p>

        <h2>Données personnelles</h2>
        <p>Le traitement de vos données à caractère personnel est régi par notre Charte du respect de la vie privée, disponible depuis la section "Charte de Protection des Données Personnelles", conformément au Règlement Général sur la Protection des Données 2016/679 du 27 avril 2016 («RGPD»).</p>
    </main>

    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>

    </footer>

</body>

</html>
