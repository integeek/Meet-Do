<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenement</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/ListeEvenement.css">
    <script src="../Script/ListeEvenement.js" defer></script>
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
        <h1>Liste des Événements</h1>
        <div class="event-content">
            <table border="1">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Voir</th>
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
    </main>

    <footer>
        <div id="footer-container" class="footer-container"></div>
        <script src="../component/Footer/Footer.js"></script>
        <script>
            (async () => {
                document.getElementById('footer-container').innerHTML = await Footer("..");
            })();
        </script>
    </footer>

</body>

</html>