let connect = {
  connect: false,
  firstName: "",
  lastName: "",
  email: "",
  role: "",
};

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
            resolve(connect);
          } else {
            console.error("Error:", responseData.message);
            connect.connect = false;
            resolve(connect);
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
          connect.connect = false;
          resolve(connect);
        }
      } else if (this.readyState == 4) {
        console.error("Error: Unable to fetch data. Status:", this.status);
        connect.connect = false;
        resolve(connect);
      }
    };
  });
};

async function Navbar(url) {
    console.log("Navbar appelée avec url :", url);
    try {
        await GetCookie();
        let photoProfil = `${url}/assets/img/profil.png`; 

        if (connect.connect) {
            try {
                console.log("Tentative de fetch photo de profil...");
                const response = await fetch('../../controller/Compte/PhotoController.php', { method: 'GET' });
                console.log("Réponse fetch reçue :", response);
                const data = await response.json();
                if (data.photo && data.photo !== "null" && data.photo !== "") {
                    photoProfil = data.photo;
                }
            } catch (e) {
                console.error("Impossible de charger la photo de profil dans la NavBar : ", e);
            }

            console.log("Photo de profil utilisée dans la navbar :", photoProfil);

            return `
                <nav> 
                    <a href="./accueil" class="nav-icon" aria-label="homepage" aria-current="page">
                        <img src="${url}/assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                    </a>
                    <div class="main-navlinks">
                        <button type="button" class="hamburger" aria-label="Toggle Navigation" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <ul class="nav-links">
                            <li><a href="./accueil">Accueil</a></li>
                            <li><a href="./Messagerie">Messagerie</a></li>
                        </ul>
                    </div>
                    <div id="navbar-grow"></div>
                    <div class="nav-authentication">
                        <div class="icone1">
                            <a href="./pageCompte" class="user-toggler" aria-label="Sign in page">
                                <img src="../assets/img/user.svg" alt="user icon" />
                            </a>
                        </div>
                        <div class="sign-btns">
                            ${
                              connect.role == "Administrateur"
                                ? `<div class="annonce"><a href="./TableauBord.php">Administrateur</a></div>`
                                : ""
                            }
                            ${
                              connect.role == "Meeter" || connect.role == "Administrateur"
                                ? `
                            <div class="annonce">
                                <a href="./CreerActivite">Poster une annonce</a>
                            </div>
`
                                : ""
                            }
                            <a href="./PageCompte" class="profil" id="profil">
                                <div class="text-overflow">${connect.firstName} ${connect.lastName}</div>
                                <img src="${photoProfil}" id="navbar-profile-icon" style="object-fit:cover;width:40px;height:40px;border-radius:50%;">
                            </a>
                            <div class="deconnexion">
                                <a id="logout-btn" href="../../../controller/Authentification/Deconnexion.php">Se déconnecter</a>
                            </div>
                        </div>
                    </div>
                </nav>
            `;
        } else {
            return `
                <nav> 
                    <a href="./accueil" class="nav-icon" aria-label="homepage" aria-current="page">
                        <img src="${url}/assets/img/logoMeet&Do.png" alt="logo" id="logo" />
                    </a>
                    <div class="main-navlinks">
                        <button type="button" class="hamburger" aria-label="Toggle Navigation" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <ul class="nav-links">
                            <li><a href="./accueil">Accueil</a></li>
                        </ul>
                    </div>
                    <div id="navbar-grow"></div>
                    <div class="nav-authentication">
                        <div class="icone1">
                            <a href="./Connexion" class="user-toggler" aria-label="Sign in page">
                                <img src="../assets/img/user.svg" alt="user icon" />
                            </a>
                        </div>
                        <div class="sign-btns">
                            <div class="annonce">
                                <a href="./Inscription">S'inscrire</a>
                            </div>
                            <div class="annonce">
                                <a href="./Connexion" class="" id="">Se connecter</a>
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
