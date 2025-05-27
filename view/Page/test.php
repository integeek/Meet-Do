<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../component/Navbar/Navbar.css" />
</head>
<body>
<nav class="navbar-container">
                    <a href="./accueil.php" class="nav-icon" aria-label="homepage" aria-current="page">
                        <img src="../assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                    </a>
                    <div class="main-navlinks">
                        <button type="button" class="hamburger" aria-label="Toggle Navigation" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <ul class="nav-links">
                            <li><a href="./PageCompte.php">Mes informations</a></li>
                            <li><a href="./Messagerie.php">Mes discussions</a></li>
                            <li><a href="./noReservation.php">Mes réservations</a></li>
                            <li><a href="#">Mes activités</a></li>

                        </ul>
                    </div>
                    <div id="navbar-grow"></div>
                    <div class="nav-authentication">
                        <div class="icone1">
                            <a href="#" class="user-toggler" aria-label="Sign in page">
                                <img src="../assets/img/user.svg" alt="user icon" />
                            </a>
                        </div>
                        <div class="sign-btns">
                            <div class="annonce">
                                <a href="./CreerActivite.php">Retour à l’accueil</a>
                            </div>
                        </div>
                    </div>
                </nav>
                <script src="../component/Navbar/navAction.js"></script>
</body>
</html>