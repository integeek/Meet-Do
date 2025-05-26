<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Connexion');
    exit;
} else if ($_SESSION['user']['role'] !== "Administrateur" && $_SESSION['user']['role'] !== "Meeter") {
    header('Location: ../Page/accueil');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste d'attente</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/ListeAttente.css">
    <script src="../Script/ListeAttente.js" defer></script>
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/NavbarCompte.js"></script>
        <script>
            (async () => {
                document.getElementById('navbar-container').innerHTML = await NavbarCompte("../../view");
            })();
        </script>
    </header>

    <main>
        <div class="info-container">
            <p>Vous êtes sur la liste d'attente pour l'activité : <strong id="activity-name"></strong></p>
            <p>Date sélectionné: <strong id="activity-date"></strong></p>
            <p>Nombre de places réservé : <strong id="reserved-places"></strong></p>
        </div>
        <h2>Participants</h2>
        <div class="participants-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Nombre de place</th>
                        <th>Annuler</th>
                    </tr>
                </thead>
                <tbody id="tableauCorps">
                </tbody>
            </table>
            <div class="custom-pagination">
                <button class="pagination-arrow" id="prev-page" aria-label="Page précédente">
                    <img src="../assets/img/icons/arrow-icon.svg" alt="Précédent">
                </button>
                <span class="pagination-pages">
                </span>
                <button class="pagination-arrow next" id="next-page" aria-label="Page suivante">
                    <img src="../assets/img/icons/arrow-icon.svg" alt="Suivant">
                </button>
            </div>
        </div>
        <h2>Liste d'attente</h2>
        <div class="liste-attente-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Nombre de place</th>
                        <th>Annuler</th>
                    </tr>
                </thead>
                <tbody id="list-attente-body">
                </tbody>
            </table>
            <div class="custom-pagination">
                <button class="pagination-arrow" id="prev-page2" aria-label="Page précédente">
                    <img src="../assets/img/icons/arrow-icon.svg" alt="Précédent">
                </button>
                <span class="pagination-pages">
                </span>
                <button class="pagination-arrow next" id="next-page2" aria-label="Page suivante">
                    <img src="../assets/img/icons/arrow-icon.svg" alt="Suivant">
                </button>
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