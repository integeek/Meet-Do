function Navbar(connect, url) {
    if (connect) {
        return `
            <nav> 
                <a href="../index.html" class="nav-icon" aria-label="homepage" aria-current="page">
                    <img src="${url}/assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                </a>
                <div class="main-navlinks">
                    <button type="button" class="hamburger"  aria-label="Toggle Navigation" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                    </button>
                    <ul class="nav-links">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Messagerie</a></li>
                    </ul>
                </div>

                <div id="navbar-grow"></div>
                <div class="nav-authentication">
                    <div class = "icone1">
                        <a href="#" class="user-toggler" aria-label="Sign in page">
                            <img src="../assets/img/user.svg" alt="user icon" />
                        </a>
                    </div>
                    <div class="sign-btns">
                        <div class="annonce">
                            <a href="#">Poster une annonce</a>
                        </div>
                        <a href="./Page/Profil.html" class="profil" id="profil">
                            <div>Profil</div>
                            <image src="${url}/assets/img/profil.png" id="profil-img">
                        </a>
                    </div>
                </div>
            </nav>
    `;
    } else {
        return `
            <nav> 
                <a href="../index.html" class="nav-icon" aria-label="homepage" aria-current="page">
                    <img src="${url}/assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                </a>
                <div class="main-navlinks">
                    <button type="button" class="hamburger"  aria-label="Toggle Navigation" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                    </button>
                    <ul class="nav-links">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Messagerie</a></li>
                    </ul>
                </div>

                <div id="navbar-grow"></div>
                <div class="nav-authentication">
                    <div class = "icone1">
                        <a href="#" class="user-toggler" aria-label="Sign in page">
                            <img src="../assets/img/user.svg" alt="user icon" />
                        </a>
                    </div>
                    <div class="sign-btns">
                        <div class="annonce">
                            <a href="#">Poster une annonce</a>
                        </div>
                        <a href="./Page/Connexion.html" class="profil" id="profil">
                            <div>Profil</div>
                            <image src="${url}/assets/img/profil.png" id="profil-img">
                        </a>
                    </div>
                </div>
            </nav>
    `;
    }
};