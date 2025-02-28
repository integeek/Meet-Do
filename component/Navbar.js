function Navbar(connect) {
    if (connect) {
        return `
            <nav>
                <img src="./assets/img/logoMeet&Do.png" id="logo">
                <ul class="nav-links">
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Messagerie</a></li>
                </ul>
                <div id="navbar-grow"></div>
                <div class="annonce">
                    <a href="#">Poster une annonce</a>
                </div>
                <a href="#" class="profil" id="profil">
                    <div>Profil</div>
                    <image src="./assets/img/profil.png" id="profil-img">
                </a>
            </nav>
    `;
    } else {
        return `
            <nav>
                <img src="./assets/img/logoMeet&Do.png" id="logo">
                <div id="navbar-grow"></div>
                <div class="annonce">
                    <a href="#">S'inscrire</a>
                </div>
                <div class="annonce">
                    <a href="#">Se connecter</a>
                </div>
            </nav>
    `;
    }
};