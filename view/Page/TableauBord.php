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
    <title>Statisqtiques</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/SideBarAdmin/SideBarAdmin.css">
    <link rel="stylesheet" type="text/css" href="../Style/TableauBord.css">
    <script src="../Script/TableauBord.js" defer></script>
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
        <div class="flexbox-container">
            <div id="sidebar-container" class="sidebar-container"></div>
            <script src="../component/SideBarAdmin/SideBarAdmin.js"></script>
            <script>
                document.getElementById('sidebar-container').innerHTML = SideBarAdmin(true, "..");
            </script>
            <div id="content-container">
                <h1>Tableau de bord</h1>
                <div id="statisqtiques-container">
                    <div id="nb-clients">
                        <p>Utilisateurs enregistrés </p>
                        <h2 id="client-container-content">80</h2>
                    </div>
                    <div id="nb-activity">
                        <p>Nombres d'activités quotidiennes</p>
                        <h2 id="activity-container-content">200</h2>
                    </div>
                </div>
                <div id="graphic-container">
                    <div id="popularity-chart-container">
                        <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
                    </div>
                    <div id="nb-activité-chart-container">
                        <canvas id="myChart2" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>
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