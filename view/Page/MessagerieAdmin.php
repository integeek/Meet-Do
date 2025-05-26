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
    <title>Messagerie</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/SearchBarAdmin/SearchBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" type="text/css" href="../component/SideBarAdmin/SideBarAdmin.css">
    <link rel="stylesheet" href="../Style/MessagerieAdmin.css">
    <script src="../Script/MessagerieAdmin.js" defer></script>
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>
    <main>
        <div class="flexbox-container">
            <div id="sidebar-container" class="sidebar-container"></div>
            <div class="center">
                <h1>Gestion de la messagerie</h1>

                <div class="searchBarAdmin-container" id="searchBarAdmin-container"></div>

                <div class="column-container">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Sujet</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableauCorps">
                            <tr>
                                <td>Dupont</td>
                                <td>Jean</td>
                                <td>Suggestion d'une nouvelle</td>
                                <td>30/03/2025</td>
                                <td>
                                    <div class="icon-actions"><img src="../assets/img/icons/eye-open-icon.svg"
                                            alt=""><img src="../assets/img/icons/reply-icon.svg" alt=""><img
                                            src="../assets/img/icons/icon-trash.svg" alt=""></div>
                                </td>
                            </tr>
                            <tr>
                            </tr>

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
                    <div class="modal hidden" id="modal1">
                        <img src="../assets/img/icons/close-icon.svg" alt="Close" class="close">
                        <form>
                            <div class="gap">
                                <strong>De: </strong><span id="userName" class="box">XXXX</span>
                            </div>
                            <div class="gap">
                                <strong>Email: </strong><span id="userEmail" class="box">XXXX</span>
                            </div>
                            <div class="gap">
                                <strong>Titre: </strong><span id="userTitle" class="box">XXXX</span>
                            </div>
                            <div class="gap">
                                <strong>Message: </strong>
                                <p id="userMessage" class="box">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque ipsam, numquam natus reiciendis blanditiis excepturi a similique ab architecto. Similique tempora repellat, inventore odit deserunt iste aspernatur facilis non vel.</p>
                            </div>
                            <div class="button">
                                <button type="submit" id="deleteBtn" class="btn btn-primary">Supprimer</button>
                                <button type="button" id="answerBtn" class="btn btn-danger">Répondre</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal hidden" id="modal2">
                        <img src="../assets/img/icons/close-icon.svg" alt="Close" class="close">
                        <form>
                            <div class="gap">
                                <strong>Message: </strong>
                                <p id="message" class="box">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque ipsam, numquam natus reiciendis blanditiis excepturi a similique ab architecto. Similique tempora repellat, inventore odit deserunt iste aspernatur facilis non vel.</p>
                            </div>
                            <div class="gap">
                                <strong>Réponse: </strong>
                                <textarea id="answerMessage" class="input box">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque ipsam, numquam natus reiciendis blanditiis excepturi a similique ab architecto. Similique tempora repellat, inventore odit deserunt iste aspernatur facilis non vel.</textarea>
                            </div>
                            <div class="button">
                                <button type="submit" id="cancelBtn" class="btn btn-primary">Annuler</button>
                                <button type="button" id="sendBtn" class="btn btn-danger">Envoyer</button>
                            </div>
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
                document.getElementById('searchBarAdmin-container').innerHTML = SearchBarAdmin("messages");
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