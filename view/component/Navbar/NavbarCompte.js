function NavbarCompte(url) {
  return `
      <nav>
                <a href="./accueil.php" class="nav-icon" aria-label="homepage" aria-current="page">
                    <img src="${url}/assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                </a>
                <div class="main-navlinks">
                    <button type="button" class="hamburger" aria-label="Toggle Navigation" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="nav-links">
                        <li><a href="../../view/Page/PageCompte.php">Mes informations</a></li>
                        <li><a href="../../view/Page/Messagerie.php">Mes discussions</a></li>
                        <li><a href="../../view/Page/mesReservations.php">Mes réservations</a></li>
                        <li><a href="../../view/Page/mesActivites.php">Mes activités</a></li>

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
                            <a href="../../view/Page/accueil.php">Retour à l’accueil</a>
                        </div>
                    </div>
                </div>
            </nav>
`;
}
