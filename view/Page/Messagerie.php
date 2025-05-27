<?php 
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../Style/Messagerie.css">
    <script src="../Script/Messagerie.js" defer></script>
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
        <h1>Messagerie</h1>
        <div class="grid">
            <fieldset id="fieldset">

            </fieldset>
            <div class="message">
                <div class="message-content">
                </div>
                <div class="message-input invisible">
                    <input type="text" id="message" placeholder="Ecrire un message..." />
                    <input type="file" id="attachment" style="display: none;" />
                    <label id="send-attachment" for="attachment"><img src="../assets/img/icons/attachFile.svg"
                            alt="file"></label>
                    <button id="send-message">Envoyer<img src="../assets/img/icons/message.svg" alt="message"
                            class="message-input-send"></button>
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