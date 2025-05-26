<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: Connexion');
    exit;
} else if ($_SESSION['user']['role'] !== "Administrateur") {
    header('Location: ../Page/accueil');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion clients</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/SearchBarAdmin/SearchBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" type="text/css" href="../component/SideBarAdmin/SideBarAdmin.css">
    <link rel="stylesheet" href="../Style/GestionClients.css">
    <script src="../Script/GestionClient.js" defer></script>
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>
    <main>
        <div class="flexbox-container">
            <div id="sidebar-container" class="sidebar-container"></div>
            <div class="center">
                <h1>Gestion des clients</h1>

                <div class="searchBarAdmin-container" id="searchBarAdmin-container"></div>

                <div class="column-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableauCorps">

                        </tbody>
                    </table>
                </div>
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
                    <h3 id="modalTitle">Modifier le client</h3>
                    <form>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" required placeholder="Nom" />
                        </div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" required placeholder="Prénom" />
                        </div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required placeholder="Email" disabled/>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label for="role">Rôle</label>
                            <select id="role" name="role" required>
                                <option value="Administrateur">Administrateur</option>
                                <option value="Client">Client</option>
                                <option value="Meeter">Meeter</option>
                            </select>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-primary">Modifier</button>
                    </form>
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
            document.getElementById('searchBarAdmin-container').innerHTML = SearchBarAdmin("client");
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