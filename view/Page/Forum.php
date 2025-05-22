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
    <title>Forum</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/Forum.css">
    <script src="../Script/Forum.js" defer></script>
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
        <script src="../component/Navbar/navAction.js"></script>

    </header>
    <main>
        <h1>Forum</h1>
        <div style="display: flex;">
            <input type="text" class="search" placeholder="Rechercher">
            <div id="select-div">
                <select id="select"></select>
            </div>
            <div class="grow"></div>
            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] === "Administrateur" || $_SESSION['user']['role'] === "Client")): ?>
                <button type="button" id="new-question-button">
                    <p>Ajouter une question</p>
                    <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
                </button>
            <?php endif; ?>
        </div>
        <div class="collapse-container">

        </div>
        <div class="modal hidden">
            <img src="../assets/img/icons/close-icon.svg" alt="Close" class="close" id="closeModal">
            <h2>Ajouter une question</h2>
            <form>
                <div id="select-div-2">
                    <select id="select2"></select>
                </div>
                <input type="text" id="question-input" class="input" placeholder="Votre question" required>
                <textarea id="reponse-input" placeholder="Votre réponse" required></textarea>
                <button type="submit" id="submit-button">Ajouter la question</button>
            </form>
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