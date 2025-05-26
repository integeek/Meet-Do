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
    <title>Modifier les tables</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/SearchBarAdmin/SearchBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" type="text/css" href="../component/SideBarAdmin/SideBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../component/Pagination/Pagination.css">
    <link rel="stylesheet" href="../Style/ModifierTables.css">
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>
    <main>
        <div class="flexbox-container">
            <div id="sidebar-container" class="sidebar-container"></div>
            <div class="center">
                <h1>Modifier les tables</h1>
                <div class="column-container">
                    <h3>Thèmes activités</h3>
                    <div class="selection-theme">
                        <input id="InputActivity" class="textbox" type="text" placeholder="Thème">
                        <button class="buttonAjouter" id="AddActivityTheme">Ajouter</button>
                    </div>
                    <div class="themes" id="ActivitesThemes">
                        <div class="theme-box">Theme 1</div>
                        <div class="theme-box">Theme 2</div>
                        <div class="theme-box">Theme 3</div>
                    </div>

                    <h3>Thèmes forum</h3>
                    <div class="selection-theme">
                        <input id="InputForumTheme" class="textbox" type="text" placeholder="Thème">
                        <button class="buttonAjouter" id="AddForumTheme">Ajouter</button>
                    </div>
                    <div class="themes" id="ForumThemes">
                        <div class="theme-box">Theme 1</div>
                        <div class="theme-box">Theme 2</div>
                        <div class="theme-box">Theme 3</div>
                    </div>


                </div>
            </div>
        </div>
        <script src="../Script/ModifierTables.js"></script>
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

        <script src="../component/Pagination/Pagination.js"></script>
        <script>
            document.getElementById('pagination-container').innerHTML = Pagination();
        </script>
        <script src="../Script/PaginationChange.js"></script>


    </main>

    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>

</body>

</html>