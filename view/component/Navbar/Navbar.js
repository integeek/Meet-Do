let connect = {
    connect: false,
    firstName: "",
    lastName: "",
    email: "",
    role: "",
}

const GetCookie = async () => {
    return new Promise((resolve, reject) => {
        var request = new XMLHttpRequest();
        request.open("GET", "./../../controller/Navbar/Navbar.php", true);
        request.send();

        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    const responseData = JSON.parse(this.responseText);
                    console.log(responseData);
                    if (responseData.success) {
                        connect.connect = true;
                        connect.firstName = responseData.user.prenom;
                        connect.lastName = responseData.user.nom;
                        connect.email = responseData.user.email;
                        connect.role = responseData.user.role;
                        resolve(connect); // Résoudre la promesse avec les données mises à jour
                    } else {
                        console.error("Error:", responseData.message);
                        connect.connect = false;
                        resolve(connect); // Résoudre même si non connecté
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    connect.connect = false;
                    resolve(connect); // Résoudre même si une erreur survient
                }
            } else if (this.readyState == 4) {
                console.error("Error: Unable to fetch data. Status:", this.status);
                connect.connect = false;
                resolve(connect); // Résoudre même si la requête échoue
            }
        };
    });
};

async function Navbar(url) {
    try {
        await GetCookie();
        if (connect.connect) {
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
                            <li><a href="./accueil.php">Accueil</a></li>
                            <li><a href="./Messagerie.php">Messagerie</a></li>
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
                            ${connect.role == "Administrateur" ? `<div class="annonce"><a href="./TableauBord.php">Administrateur</a></div>` : ""}
                            <div class="annonce">
                                <a href="./CreerActivite.php">Poster une annonce</a>
                            </div>
                            <a href="./PageCompte.php" class="profil" id="profil">
                                <div>${connect.firstName} ${connect.lastName}</div>
                                <img src="${url}/assets/img/profil.png" id="profil-img">
                            </a>
                            <div class="deconnexion">
                                <a id="logout-btn" href="../../../Meet-Do/controller/Authentification/Deconnexion.php">Se déconnecter</a>
                            </div>
                        </div>
                    </div>
                </nav>
            `;
        } else {
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
                            <li><a href="./accueil.php">Accueil</a></li>
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
                                <a href="./Inscription.php">S'inscrire</a>
                            </div>
                            <div class="annonce">
                                <a href="./Connexion.php" class="" id="">Se connecter</a>
                            </div>
                        </div>
                    </div>
                </nav>
            `;
        }
    } catch (error) {
        console.error("Error in Navbar:", error);
        return `<p>Erreur lors du chargement de la barre de navigation.</p>`;
    }
}