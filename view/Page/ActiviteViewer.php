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
</head>

<body>
    <div class="background-image"></div>

    <header>
        <div id="navbar-container" class="navbar-container"></div>
    </header>

    <main>
        <div class="parentDiv">
            <div class="containerActivite">
                <div id="activiteDetails"></div>
                <div class="buttons-container">
                    <div id="editButton"></div>
                    <div id="deleteButton"></div>
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

    <script src="../component/Navbar/Navbar.js"></script>
    <script>
        (async () => {
            document.getElementById('navbar-container').innerHTML = await Navbar("..");
        })();
    </script>

    <script src="../component/BoutonBleu.js"></script>
    <script src="../component/BoutonRouge.js"></script>
    <script>
        function LoadActivite(activite) {
            const boutonParticiper = BoutonBleu("Participer");
            const boutonLaisserAvis = BoutonBleu("Laisser un avis");
            const boutonContact = BoutonBleu("Contactez-moi");

            return `
                <div class="activite-container">
                    <div class="titre-activite-container">
                        <div>
                            <h1 class="titre-activite">${activite.titre}</h1>
                            <p class="date-activite">Créée le ${new Date(activite.dateCreation).toLocaleDateString()}</p>
                        </div>
                        <div class="infos-activite">
                            <p class="adresse-activite"><img src="../assets/img/icons/position-icon.svg" alt=""> ${activite.adresse}</p>
                            <p class="groupe-activite"><img src="../assets/img/icons/group.svg" alt=""> Groupe de ${activite.tailleGroupe}</p>
                        </div>
                    </div>
                    <div class="images-activite">
                        ${activite.image ? `<img src="${activite.image}" alt="Image de l'activité" class="image-activite">` : ''}
                    </div>
                    <div class="separator"></div>
                    <div class="description-container">
                        <div class="description-activite">
                            <h2><img src="../assets/img/icons/file.svg" alt=""> Description de l’activité</h2>
                            <p>${activite.description}</p>
                        </div>
                        <div class="actions-container">
                            ${boutonParticiper}
                            ${boutonLaisserAvis}
                            <p class="prix-activite"><img src="../assets/img/icons/price.svg" alt=""> Prix : ${activite.prix}€</p>
                            <div class="organisateur">
                                <p class="nom-organisateur"><img src="../assets/img/icons/user.svg" alt=""> ${activite.meeterDescription}</p>
                                <p class="note-organisateur"><img src="../assets/img/icons/etoile.svg" alt=""> Note moyenne : ${activite.moyenneAvis ?? 'N/A'} / 5</p>
                                ${boutonContact}
                            </div>
                        </div>
                    </div>
                    <div class="avis-container">
                        <h2><img src="../assets/img/icons/megaphone.svg" alt=""> Avis (${activite.nombreAvis})</h2>
                        ${activite.avis.length > 0 ? activite.avis.map(avis => `
                            <div class="avis">
                                <p><strong><img src="../assets/img/icons/etoile.svg" alt=""> ${avis.note}</strong> (${new Date(avis.dateAvis).toLocaleDateString()})</p>
                                <p>${avis.commentaire}</p>
                            </div>
                        `).join('') : '<p>Aucun avis pour le moment.</p>'}
                    </div>
                </div>
            `;
        }

        function getIdFromUrl() {
            const params = new URLSearchParams(window.location.search);
            return params.get("id");
        }

        const id = getIdFromUrl();

        if (id) {
            fetch(`../../controller/Activite/ActiviteViewerController.php?id=${id}`)
                .then(response => {
                    if (!response.ok) throw new Error("Activité introuvable");
                    return response.json();
                })
                .then(activite => {
                    document.getElementById('activiteDetails').innerHTML = LoadActivite(activite);
                    document.getElementById('editButton').innerHTML = BoutonBleu("Modifier");
                    document.getElementById('deleteButton').innerHTML = BoutonRouge("Supprimer");
                })
                .catch(error => {
                    document.getElementById('activiteDetails').innerHTML = `<p class="error">Erreur : ${error.message}</p>`;
                });
        } else {
            document.getElementById('activiteDetails').innerHTML = `<p class="error">Aucun ID d'activité fourni</p>`;
        }
    </script>
</body>

</html>
