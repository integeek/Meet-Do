

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" href="../component/SearchBar/SearchBar.css">
    <link rel="stylesheet" href="../component/ActivityCard/ActivityCard.css">
    <!--<script src="activityCard.js" defer></script>-->
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
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
    </header>
    <main>
        <div id="search-bar"></div>
        <script src="../component/SearchBar/SearchBar.js"></script>
        <script>
            document.getElementById('search-bar').innerHTML = SearchBar("..")
        </script>
        <div id="activities-container"></div>
        <script src="../component/ActivityCard/ActivityCard.js"></script>
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>
</body>

</html>