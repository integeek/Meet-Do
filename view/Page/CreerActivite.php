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
    <title>Créer une activité</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" type="text/css" href="../Style/CreerActivite.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" /> <!--carte-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css" /> <!--calendrier-->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> <!--carte-->
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
    <div class="container">
        <h1>Créer une activité</h1>
        <div class="upload-container">
            <label class="upload-box"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 16V7.85l-2.6 2.6L7 9l5-5l5 5l-1.4 1.45l-2.6-2.6V16zm-5 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg><p>Upload image</p><p>5 maximum</p>
                <input type="file" id="uploadInput" multiple hidden>
            </label>
            <div id="imagePreview"></div>
        </div>
        <input type="text" id="nom" placeholder="Nom">
        <textarea id="description" placeholder="Description"></textarea>

        <!-- Sélection du thème -->
        <div class="theme-container">
            <div class="theme-selection">
                <select id="themeSelect">
                    <option value="">Thème</option>
                    <!-- Les catégories seront chargées ici dynamiquement -->
                </select>
                <button id="ajouterTheme" class="bouton-ajouter">Ajouter</button>
            </div>
            <div id="themesAjoutes"></div>
        </div>

        <!-- Sélection de l'adresse -->
        <input type="text" id="adresse" placeholder="Adresse">
        <ul id="suggestions"></ul> <!-- Liste déroulante des suggestions -->
        <button id="ouvrirCarte">Choisir sur la carte</button>
        <div id="mapPopup" class="popup hidden">
            <div id="map"></div>
            <button id="fermerCarte">Fermer</button>
        </div>

        <!-- Sélection des dates -->
        <input type="text" id="dates" placeholder="Sélectionner des dates" readonly>
        <div id="datesAjoutees"></div>

        <input type="number" id="nbPersonnes" placeholder="Nombre de personnes">
        <input type="number" id="prix" placeholder="Prix">

        <label><input type="checkbox" id="mobiliteReduite"> Accessible aux personnes à mobilité réduite</label>

        <script src="../component/BoutonBleu.js"></script>
        <div id="boutonContainer"></div>
        <script>
            document.getElementById('boutonContainer').innerHTML = BoutonBleu("Créer");
        </script>
    </div>
</main>

<footer id="footer-container" class="footer-container">
    <script src="../component/Footer/Footer.js"></script>
    <script>
        document.getElementById('footer-container').innerHTML = Footer("..");
    </script>
</footer>

<!-- Librairies pour la carte et le calendrier -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>

<script>
    // Fonction pour charger les catégories depuis le backend
async function fetchCategories() {
    try {
        const response = await fetch('../../controller/Activite/CreerActiviteController.php', { method: 'GET' });
        console.log('Response:', response); // Ajout pour débogage
        if (!response.ok) throw new Error("Erreur lors du chargement des catégories");
        const categories = await response.json();
        console.log('Categories:', categories); // Ajout pour débogage
        const selectElement = document.getElementById('themeSelect');
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.idCategorie;
            option.textContent = category.nom;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error(error);
        alert("Impossible de charger les catégories.");
    }
}

    // Ajout de thèmes
    document.getElementById('ajouterTheme').addEventListener('click', function() {
        const select = document.getElementById('themeSelect');
        const selectedThemeId = select.value;
        if (!selectedThemeId) return; // Ne rien faire si aucun thème sélectionné

        // Vérifie si le thème est déjà ajouté
        const exists = Array.from(document.querySelectorAll('#themesAjoutes .theme-badge'))
            .some(badge => badge.dataset.id === selectedThemeId);
        if (exists) return;

        const themeName = select.options[select.selectedIndex].text;

        const themeBadge = document.createElement('span');
        themeBadge.classList.add('theme-badge');
        themeBadge.textContent = themeName;
        themeBadge.dataset.id = selectedThemeId;

        const removeBtn = document.createElement('button');
        removeBtn.textContent = "✖";
        removeBtn.classList.add('remove-theme');
        removeBtn.onclick = function() {
            themeBadge.remove();
        };

        themeBadge.appendChild(removeBtn);
        document.getElementById('themesAjoutes').appendChild(themeBadge);

        select.value = "";
    });

    // Sélection des dates avec Flatpickr
    flatpickr("#dates", {
        mode: "multiple",
        dateFormat: "d/m/Y",
        onClose: function(selectedDates, dateStr) {
            document.getElementById("datesAjoutees").innerHTML = "";
            dateStr.split(", ").forEach(date => {
                let badge = document.createElement("span");
                badge.classList.add("theme-badge");
                badge.textContent = date;
                let removeBtn = document.createElement("button");
                removeBtn.textContent = "✖";
                removeBtn.classList.add("remove-theme");
                removeBtn.onclick = function() { badge.remove(); };
                badge.appendChild(removeBtn);
                document.getElementById("datesAjoutees").appendChild(badge);
            });
        }
    });

    // Affichage de la carte
    document.getElementById("ouvrirCarte").addEventListener("click", function() {
        document.getElementById("mapPopup").classList.remove("hidden");

        // Vérifie si la carte a déjà été initialisée
        if (!window.map) {
            window.map = L.map('map').setView([48.8566, 2.3522], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(window.map);
        } else {
            setTimeout(() => { 
                if (window.map) {
                    window.map.invalidateSize();
                }
            }, 300);
        }

        let marker;
        window.map.on("click", function(e) {
            if (marker) marker.remove();
            marker = L.marker(e.latlng).addTo(window.map);
            document.getElementById("adresse").value = `Lat: ${e.latlng.lat}, Lng: ${e.latlng.lng}`;
        });
    });

    document.getElementById("fermerCarte").addEventListener("click", function() {
        document.getElementById("mapPopup").classList.add("hidden");
    });


    // Gestion de l'affichage et de la suppression des images sélectionnées
    const uploadInput = document.getElementById('uploadInput');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    uploadInput.addEventListener('change', function (e) {
        const files = Array.from(e.target.files);
        // Limite à 5 images
        if (selectedFiles.length + files.length > 5) {
            alert("Vous pouvez sélectionner jusqu'à 5 images maximum.");
            uploadInput.value = "";
            return;
        }
        files.forEach(file => {
            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = function (event) {
                const imgDiv = document.createElement('div');
                imgDiv.classList.add('img-preview-item');
                imgDiv.innerHTML = `
                    <img src="${event.target.result}" alt="Image" />
                    <button type="button" class="remove-img-btn">✖</button>
                `;
                imgDiv.querySelector('.remove-img-btn').onclick = function () {
                    const idx = Array.from(imagePreview.children).indexOf(imgDiv);
                    selectedFiles.splice(idx, 1);
                    imgDiv.remove();
                    // Met à jour le FileList de l'input
                    updateInputFiles();
                };
                imagePreview.appendChild(imgDiv);
            };
            reader.readAsDataURL(file);
        });
        // Met à jour le FileList de l'input
        updateInputFiles();
    });

    // Fonction pour mettre à jour le FileList de l'input avec les fichiers sélectionnés
    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        uploadInput.files = dataTransfer.files;
    }

    // Fonction pour envoyer les données au backend
    async function submitActivityData() {
        try {
            const formData = new FormData();
            formData.append('titre', document.getElementById('nom').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('mobiliteReduite', document.getElementById('mobiliteReduite').checked ? 1 : 0);
            formData.append('adresse', document.getElementById('adresse').value);
            formData.append('dates', Array.from(document.querySelectorAll('#datesAjoutees .theme-badge')).map(badge => badge.textContent).join(', '));
            formData.append('tailleGroupe', document.getElementById('nbPersonnes').value);
            formData.append('prix', document.getElementById('prix').value);

            // Récupérer les thèmes sélectionnés (IDs)
            const themes = Array.from(document.querySelectorAll('#themesAjoutes .theme-badge')).map(badge => badge.dataset.id);
            console.log("IDs des thèmes envoyés :", themes);
            formData.append('themes', JSON.stringify(themes));

            // Ajouter les images
            const imageInputs = document.getElementById('uploadInput').files;
            for (const file of imageInputs) {
                formData.append('images[]', file);
                console.log("Image ajoutée : " + file.name);
            }

            const response = await fetch('../../controller/Activite/CreerActiviteController.php', {
                method: 'POST',
                body: formData
            });
            const sqlQuery = response.headers.get('X-SQL-Query');
const sqlError = response.headers.get('X-SQL-Error');
if (sqlQuery) console.log("SQL exécutée :", sqlQuery);
if (sqlError) console.error("Erreur SQL :", sqlError);

            if (response.ok) {
                console.log("Activité créée avec succès.");
                //window.location.href = '../Page/accueil.php';
            } else {
                const errorText = await response.text();
                console.log("Erreur lors de la création de l'activité : " + errorText);
            }
        } catch (error) {
            console.error(error);
            console.log("Une erreur est survenue lors de l'envoi des données.");
        }
    }

    // Ajout d'un event listener pour le bouton de création de l'activité
    document.getElementById('boutonContainer').addEventListener('click', function() {
        submitActivityData();
    });

    // Fetch categories on page load
    window.onload = fetchCategories;
</script>
<script src="../Script/InfoPerso.js"></script>


</body>
</html>