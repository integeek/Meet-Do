<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Connexion.php');
    exit;
} else if ($_SESSION['user']['role'] !== "Administrateur") {
    header('Location: ../Page/accueil.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepter meeters</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/SearchBarAdmin/SearchBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" type="text/css" href="../component/SideBarAdmin/SideBarAdmin.css">
    <link rel="stylesheet" href="../Style/AccepterMeeter.css">
    <script src="../Script/AccepterMeeter.js" defer></script>
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>
    <main>
        <div class="flexbox-container">
            <div id="sidebar-container" class="sidebar-container"></div>
            <div class="center">
                <h1>Gestion des nouveaux meeters</h1>

                <div class="searchBarAdmin-container" id="searchBarAdmin-container"></div>

                <div class="column-container">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Date de la demande</th>
                                <th>Demande</th>
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
                        <button class="pagination-arrow" id="next-page" aria-label="Page suivante">
                            <img src="../assets/img/icons/arrow-icon.svg" alt="Suivant">
                        </button>
                    </div>
                    <div class="modal hidden">
                        <img src="../assets/img/icons/close-icon.svg" alt="Close" class="close" id="closeModal">
                        <h3 id="modalTitle">Demande pour devenir Meeter</h3>
                        <form>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <img src="../assets/img/icons/user.svg" alt="User" class="icon">
                                <div>
                                    <p id="userName">Nom Prénom</p>
                                    <p id="userAdress">Adresse</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <strong>Description</strong>
                                <p class="box" id="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <strong>N° Téléphone: </strong>
                                <p class="box" id="userPhone">+33 6 12 34 56 78</p>
                            </div>
                            <div class="button">
                                <button type="submit" id="deleteBtn" class="btn btn-primary">Refuser le Meeter</button>
                                <button type="button" id="blockBtn" class="btn btn-danger">Valider le Meeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../component/Navbar/Navbar.js"></script>
        <script>
            (async () => {
                document.getElementById('navbar-container').innerHTML = await Navbar("..");
            })();
        </script>
        <script src="../component/Navbar/navAction.js"></script>

        <script src="../component/SideBarAdmin/SideBarAdmin.js"></script>
        <script>
            document.getElementById('sidebar-container').innerHTML = SideBarAdmin(true, "..");
        </script>

        <script src="../component/SearchBarAdmin/SearchBarAdmin.js"></script>
        <script>
            document.getElementById('searchBarAdmin-container').innerHTML = SearchBarAdmin("demandes");
        </script>
    </main>

    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>

</body>

</html>