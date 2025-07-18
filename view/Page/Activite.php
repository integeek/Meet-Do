<?php 
session_start();
$messageErreur = $_SESSION["erreur"] ?? "";
unset($_SESSION["erreur"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activité Viewer</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonRouge.css">
    <link rel="stylesheet" type="text/css" href="../Style/ActiviteViewer.css">
    <link rel="stylesheet" type="text/css" href="../component/LoadActivite.css">
    <link rel="stylesheet" type="text/css" href="../Style/star.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

</head>

<body>
    <div class="background-image"></div>
    
    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>

    <main>
        <div class="parentDiv">
            <div class="containerActivite">
                <div id="activiteDetails">
                    <div class="activite-container">
                        <div class="titre-activite-container">
                            <div>
                                <h1 class="titre-activite">Atelier Macaron</h1>
                                <!-- <p class="date-activite">10 Février 2025</p> -->
                            </div>
                            <div class="infos-activite">
                                <p class="adresse-activite"><img src="../assets/img/icons/position-icon.svg" alt=""> 10 rue de Vanves, 92130, Issy-les-Moulineaux</p>
                                <p class="groupe-activite"><img src="../assets/img/icons/group.svg" alt=""> Groupe de 10</p>
                                <p class="duree-activite"><img src="../assets/img/icons/clock-icon.svg" alt=""> 2h</p>
                                <p onclick="openPopUp('popup-report')" class="report-activite"><img src="../assets/img/icons/report-icon.svg" alt="">Signaler</p>
                            </div>
                        </div>
                        <div class="images-activite-carousel">
                            <button class="carousel-arrow left" id="carouselPrev">&#10094;</button>
                            <div class="carousel-track-container">
                                <div class="carousel-track" id="carouselTrack">
                                    <!-- Les images seront injectées ici dynamiquement -->
                                </div>
                            </div>
                            <button class="carousel-arrow right" id="carouselNext">&#10095;</button>
                        </div>
                        <div class="separator"></div>
                        <div class="description-container">
                            <div class="description-activite">
                                <h2><img src="../assets/img/icons/file.svg" alt=""> Description de l’activité</h2>
                                <p>Rejoignez-nous pour un atelier gourmand et créatif où vous apprendrez à réaliser de délicieux macarons maison. Encadré par un pâtissier expérimenté, vous découvrirez les secrets d'une coque parfaite, la préparation d'une ganache savoureuse et les astuces pour un résultat digne des grands chefs. Que vous soyez débutant ou amateur passionné, cet atelier vous permettra de développer vos compétences culinaires. Repartez avec vos propres créations et émerveillez vos proches !</p>
                                <div id="map" style="height: 400px; width: 100%; margin: 20px 0;"></div>
                            </div>
                            <div class="actions-container">
                                <div class="boutonActivite">
                                    <div class="btn-bleu" id="boutonParticiper"></div>
                                    <div class="btn-bleu" id="boutonAvis"></div>
                                </div>
                                <div class="erreur" style="color: red; margin-bottom: 1rem;">
                                    <?= htmlspecialchars($messageErreur) ?>
                                </div>
                                <p class="prix-activite"><img src="../assets/img/icons/price.svg" alt=""> Prix : 300€</p>
                                <div class="organisateur">
                                    <p class="nom-organisateur" id="meeter-page"><img src="../assets/img/icons/user.svg" alt=""> Jean Dupont</p>
                                    <p class="note-organisateur"><img src="../assets/img/icons/etoile.svg" alt=""> 4.89 / 5</p>
                                    <div class="btn-bleu" id="boutonContact"></div>
                                </div>
                            </div>
                        </div>
                        <div class="avis-container">
                            <h2><img src="../assets/img/icons/megaphone.svg" alt=""> Avis (2)</h2>
                            <div class="avis">
                                <p><strong>Alice</strong> <img src="../assets/img/icons/etoile.svg" alt=""> 4.5</p>
                                <p>Accueil chaleureux, je recommande</p>
                            </div>
                            <div class="avis">
                                <p><strong>Axel</strong> <img src="../assets/img/icons/etoile.svg" alt=""> 2.9</p>
                                <p>Expérience mitigée</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pop-up participer à une activité -->
                <div class="popup-overlay" id="popup">
                    <div class="popup-content">
                        <div class="close-cross" onclick="closePopUp('popup')">✕</div>
                        <h1>Participer à l'activité</h1>
                      
                        <div class="popup-main">
                          <div class="form-section">
                            <p>Nombre de participants</p>
                            <input class="textbox" type="text" name="nbParticipant" id="nbPlace" required>
                            <p>Choisissez votre date</p>
                            <input type="text" id="datepicker" placeholder="Choisissez une date disponible">
                          </div>
                      
                          <div class="creneaux-section">
                            <h3>Créneaux disponibles</h3>
                            <div id="creneaux-container"></div>
                          </div>
                        </div>
                        <div class="popup-buttons">
                          <div id="bouton-rouge" class="boutonPar" onclick="closePopUp('popup')"></div>
                          <div id="boutonBleuPop" class="boutonPar"></div>
                        </div>
                      </div>            
                        <script src="../component/BoutonRouge.js"></script>
                        <script src="../Script/Activite.js"></script>
                        <script>
                            document.getElementById('bouton-rouge').innerHTML = BoutonRouge("Annuler");
                        </script>
                        <script src="../component/BoutonBleu.js"></script>
                        <script>
                            document.getElementById('boutonBleuPop').innerHTML = BoutonBleu("Valider");
                        </script>
                </div>

                <!-- Pop up globale pour signaler ou bloquer  -->
                <div class="popup-overlay" id="popup-report">
                    <div class="containerPopUp">
                        <div class="close-cross" onclick="closePopUp('popup-report')">✕</div>
                        <h1>Autres actions :</h1>
                            <div class="bouton-report">
                                <div class="boutonRo" id="bouton-rouge1" onclick="openPopUp('popup-report-activity')"></div>
                                <script>
                                document.getElementById('bouton-rouge1').innerHTML = BoutonRouge("Signaler l'activité");
                                </script>
                                <div class="boutonRo" id="bouton-rouge2"  onclick="openPopUp('popup-report-user')" onclick="closePopUp('popup-report-user')"></div>
                                <script>
                                document.getElementById('bouton-rouge2').innerHTML = BoutonRouge("Signaler le meeter");
                                </script>
                                <div class="boutonRo" id="bouton-rouge3" onclick="closePopUp('popup-report')"></div>
                                <script>
                                document.getElementById('bouton-rouge3').innerHTML = BoutonRouge("Bloquer l'utilisateur");
                                </script>
                            </div>
                    </div>
                </div>

                <div class="popup-overlay" id="popup-report-user">
                    <div class="containerReport">
                        <div class="close-cross" onclick="closePopUp('popup-report-user')">✕</div>

                        <h1>Signaler un utilisateur</h1>
                        <p>Raison du signalement<p></p>
                        <form action="../../controller/Signalement/SignalementUser.php" method="POST">
                        <input type="hidden" name="idActivite" value="<?= $_GET['id'] ?>">
                        <div class="container">
                            <p ><input type="radio" name="raison" value="Manque de respect">Manque de respect</p>
                            <p ><input type="radio" name="raison" value="Publicité déguisée">Publicité déguisée</p>
                            <p ><input type="radio" name="raison" value="Problème de localisation">Problème de localisation</p>
                            <p ><input type="radio" name="raison" value="Texte inapproprié">Texte inapproprié</p>
                            <p ><input type="radio" name="raison" value="Photo inappropriée">Photo inappropriée</p>
                            <p ><input type="radio" name="raison" value="Autre">Autre</p>            
                        </div>
                        
                            <p>Commentaire : (facultatif)</p>
                            <textarea class="textComm" name="Commentaire" rows="4" cols="38"></textarea>
                            <div class="popup-buttonsReport">
                                <div id="bouton-rougeUser" onclick="closePopUp('popup-report-user')"></div>
                                <div id="bouton-bleueUser"></div>
                            </div>
                        </form>   

                            <script>
                                document.getElementById('bouton-rougeUser').innerHTML = BoutonRouge("Annuler");
                            </script>
                            <script>
                                document.getElementById('bouton-bleueUser').innerHTML = BoutonBleu("Signaler");
                            </script>
                    </div>
                </div>

                <div class="popup-overlay" id="popup-report-activity">
                    <div class="containerReport">
                        <div class="close-cross" onclick="closePopUp('popup-report-activity')">✕</div>
                        <h1>Signaler une activité</h1>
                        <p>Raison du signalement<p></p>
                        <form action="../../controller/Signalement/SignalementActivite.php" method="POST">
                        <input type="hidden" name="idActivite" value="<?= $_GET['id'] ?>">
                        <div class="container">
                            <p ><input type="radio" name="raison" value="Activité dangereuse">Activité dangereuse</p>
                            <p ><input type="radio" name="raison" value="Publicité déguisée">Publicité déguisée</p>
                            <p ><input type="radio" name="raison" value="Problème de localisation">Problème de localisation</p>
                            <p ><input type="radio" name="raison" value="Texte inapproprié">Texte inapproprié</p>
                            <p ><input type="radio" name="raison" value="Photo inappropriée">Photo inappropriée</p>
                            <p ><input type="radio" name="raison" value="Autre">Autre</p>                
                        </div>
                            <p>Commentaire : (facultatif)</p>
                            <textarea class="textComm" name="Commentaire" rows="4" cols="38"></textarea>
                            <div class="popup-buttonsReport">
                                <div id="bouton-rougeActivity" onclick="closePopUp('popup-report-activity')"></div>
                                <div id="bouton-bleueActivity"></div>
                        </div>
                        </form>   

                            <script>
                                document.getElementById('bouton-rougeActivity').innerHTML = BoutonRouge("Annuler");
                            </script>
                            <script>
                                document.getElementById('bouton-bleueActivity').innerHTML = BoutonBleu("Signaler");
                            </script>
                    </div>
                </div>
                <!-- Pop up pour laisser un avis -->
                <div class="popup-overlay" id="popup-avis">
                    <div class="popup-content" id="popup-avis-content">
                        <div class="close-cross" onclick="closePopUp('popup-avis')">✕</div>
                        <h1>Laisser un avis</h1>

                        <div class="popup-main">
                        <form action="../../controller/Avis/Avis.php" method="POST">
                            <input type="hidden" name="idActivite" value="<?= $_GET['id'] ?>">
                            <input type="hidden" name="idMeeter" value="<?= $_SESSION["user"]["id"]?>">

                            <div class="popup-rating">
                            <p>Qu’avez-vous pensé de votre expérience ?</p>
                            <div class="star-rating">
                                <input type="radio" name="star-rating" id="star5" value="5" />
                                <label for="star5">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2
                                        9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                </label>

                                <input type="radio" name="star-rating" id="star4" value="4" />
                                <label for="star4">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2
                                        9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                </label>

                                <input type="radio" name="star-rating" id="star3" value="3" />
                                <label for="star3">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2
                                        9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                </label>

                                <input type="radio" name="star-rating" id="star2" value="2" />
                                <label for="star2">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2
                                        9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                </label>

                                <input type="radio" name="star-rating" id="star1" value="1" />
                                <label for="star1">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2
                                        9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                </label>
                            </div>
                            </div>

                            <div class="popup-comment">
                            <p>Avez-vous un commentaire à ajouter ? Racontez-nous !</p>
                            <div class="comment-box">
                                <textarea name="commentaire" id="comment" spellcheck="true"></textarea>
                            </div>
                            <p>Merci pour votre avis, il sera utile pour de futurs participants.</p>
                            </div>

                            <div class="popup-buttons">
                            <div id="bouton-rouge-avis" class="boutonPar" onclick="closePopUp('popup-avis')"></div>
                            <div id="bouton-bleu-avis" class="boutonPar"></div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>


<script>
  document.getElementById('bouton-rouge-avis').innerHTML = BoutonRouge("Annuler");
  document.getElementById('bouton-bleu-avis').innerHTML = BoutonBleu("Publier votre avis");
</script>
                        

    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>
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

    <script src="../Script/PopUp.js"></script>
    <script>
        document.getElementById('boutonParticiper').innerHTML = BoutonBleu("Participer");
        const bouton = document.querySelector('#boutonParticiper button');
        console.log(bouton);
        bouton.addEventListener('click', () => openPopUp("popup"));
    </script>

    <script src="../Script/PopUp.js"></script>
    <script>
        document.getElementById('boutonAvis').innerHTML = BoutonBleu("Laisser un avis");
        const bouton1 = document.querySelector('#boutonAvis button');
        console.log(bouton1);
        bouton1.addEventListener('click', () => openPopUp("popup-avis"));
    </script>
    
    <script>
        document.getElementById('boutonContact').innerHTML = BoutonBleu("Contactez moi");
    </script>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        if (!id) {
            console.error("ID de l'activité manquant dans l'URL.");
            document.body.innerHTML = "<h1>ID de l'activité manquant dans l'URL.</h1>";
            return;
        }

        try {
            const response = await fetch(`../../controller/Activite/ActiviteViewerController.php?id=${id}`);
            const data = await response.json();
            window.activiteData = data; // Rendez la variable globale pour d'autres fichiers JS

            if (data.error) {
                alert(data.error);
                return;
            }

            // Remplissage dynamique de la page
            document.querySelector(".titre-activite").textContent = data.titre;
            document.querySelector(".adresse-activite").innerHTML = `<img src="../assets/img/icons/position-icon.svg" alt=""> ${data.adresse}`;
            document.querySelector(".groupe-activite").innerHTML = `<img src="../assets/img/icons/group.svg" alt=""> Groupe de ${data.tailleGroupe}`;
            document.querySelector(".prix-activite").innerHTML = `<img src="../assets/img/icons/price.svg" alt=""> Prix : ${data.prix}€`;
            document.querySelector(".description-activite p").textContent = data.description;
            document.querySelector(".nom-organisateur").innerHTML = `<img src="../assets/img/icons/user.svg" alt=""> ${data.prenom} ${data.nom}`;
            document.querySelector(".note-organisateur").innerHTML = `<img src="../assets/img/icons/etoile.svg" alt=""> ${data.moyenneAvis ?? "Pas encore de note"} / 5`;

            const imagesContainer = document.querySelector(".images-activite-carousel #carouselTrack");
            const prevBtn = document.getElementById("carouselPrev");
            const nextBtn = document.getElementById("carouselNext");

            let currentIndex = 0;
            let imagesToShow = window.innerWidth < 800 ? 1 : 2;

            function updateImagesToShow() {
                imagesToShow = window.innerWidth < 800 ? 1 : 2;
                updateCarousel();
            }

            window.addEventListener('resize', updateImagesToShow);

            function updateCarousel() {
                const total = data.images.length;
                // Clamp index
                if (currentIndex < 0) currentIndex = 0;
                if (currentIndex > total - imagesToShow) currentIndex = total - imagesToShow;
                if (currentIndex < 0) currentIndex = 0;
                // Move track
                const percent = (100 / imagesToShow) * currentIndex;
                imagesContainer.style.transform = `translateX(-${percent}%)`;
                // Disable arrows if needed
                prevBtn.style.visibility = currentIndex === 0 ? "hidden" : "visible";
                nextBtn.style.visibility = currentIndex >= total - imagesToShow ? "hidden" : "visible";
            }

            // Inject images
            if (data.images && data.images.length > 0) {
                imagesContainer.innerHTML = data.images.map(src => `
                    <img src="${src}" alt="Image de l'activité" class="carousel-img">
                `).join('');
            } else {
                imagesContainer.innerHTML = `
                    <img src="../../view/assets/img/placeholder.png" alt="Aucune image disponible" class="carousel-img">
                `;
            }

            updateCarousel();

            prevBtn.onclick = () => { currentIndex--; updateCarousel(); };
            nextBtn.onclick = () => { currentIndex++; updateCarousel(); };

            // Drag/swipe support
            let startX = 0, isDown = false, moved = false;
            imagesContainer.addEventListener('mousedown', e => {
                isDown = true; startX = e.pageX; moved = false;
            });
            imagesContainer.addEventListener('mousemove', e => {
                if (!isDown) return;
                let dx = e.pageX - startX;
                if (Math.abs(dx) > 50) {
                    if (dx > 0 && currentIndex > 0) { currentIndex--; updateCarousel(); }
                    if (dx < 0 && currentIndex < data.images.length - imagesToShow) { currentIndex++; updateCarousel(); }
                    isDown = false;
                }
            });
            imagesContainer.addEventListener('mouseup', () => { isDown = false; });
            imagesContainer.addEventListener('mouseleave', () => { isDown = false; });
            // Touch events (mobile)
            imagesContainer.addEventListener('touchstart', e => { isDown = true; startX = e.touches[0].clientX; });
            imagesContainer.addEventListener('touchmove', e => {
                if (!isDown) return;
                let dx = e.touches[0].clientX - startX;
                if (Math.abs(dx) > 50) {
                    if (dx > 0 && currentIndex > 0) { currentIndex--; updateCarousel(); }
                    if (dx < 0 && currentIndex < data.images.length - imagesToShow) { currentIndex++; updateCarousel(); }
                    isDown = false;
                }
            });
            imagesContainer.addEventListener('touchend', () => { isDown = false; });

            const avisContainer = document.querySelector(".avis-container");
            if (data.avis.length > 0) {
                avisContainer.innerHTML = `
                    <h2><img src="../assets/img/icons/megaphone.svg" alt=""> Avis (${data.nombreAvis})</h2>
                    ${data.avis.map(a => `
                        <div class="avis">
                            <p style="display:flex; align-items: center; gap:10px"><strong>Utilisateur</strong> <img src="../assets/img/icons/etoile.svg" alt=""> ${a.note}</p>
                            <p>${a.commentaire}</p>
                        </div>
                    `).join("")}
                `;
            } else {
                avisContainer.innerHTML = `<h2><img src="../assets/img/icons/megaphone.svg" alt=""> Aucun avis pour le moment</h2>`;
            }

        } catch (err) {
            console.error("Erreur lors du chargement de l'activité :", err);
            document.body.innerHTML = "<h1>Erreur lors du chargement de l'activité</h1>";
        }
    });
</script>

</body>

</html>