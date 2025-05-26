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
    <div class="container">
        <h1>Créer une activité</h1>
        <div class="upload-container">
            <button type="button" id="openImagePopup" class="open-popup-btn">Ajouter des images</button>
            <div id="mainImagePreview"></div>
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

        <!-- Sélection des dates -->
        <input type="text" id="dates" placeholder="Sélectionner des dates" readonly>
        <div id="datesAjoutees"></div>

        <input type="number" id="nbPersonnes" placeholder="Nombre de personnes">
        <input type="number" id="prix" placeholder="Prix">

        <label style="display: flex; align-items: center; gap: 10px;"><input type="checkbox" id="mobiliteReduite"> Accessible aux personnes à mobilité réduite</label>

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
document.addEventListener('DOMContentLoaded', function() {
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
            enableTime: true,
            noCalendar: false,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            onClose: function(selectedDates, dateStr) {
                document.getElementById("datesAjoutees").innerHTML = "";
                dateStr.split(", ").forEach(date => {
                    let badge = document.createElement("span");
                    badge.classList.add("theme-badge");
                    badge.textContent = date;
                    let removeBtn = document.createElement("button");
                    removeBtn.textContent = "✖";
                    removeBtn.classList.add("remove-theme");
                    removeBtn.onclick = function() {
                        badge.remove();
                    };
                    badge.appendChild(removeBtn);
                    document.getElementById("datesAjoutees").appendChild(badge);
                });
            }
        });

    // Gestion de l'affichage et de la suppression des images sélectionnées
    const uploadInput = document.getElementById('uploadInput');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    function openPopUp(id) {
        document.getElementById('overlay').style.display = "block";
        document.getElementById(id).style.display = "block";
    }
    function closePopUp(id) {
        document.getElementById('overlay').style.display = "none";
        document.getElementById(id).style.display = "none";
    }

    document.getElementById('openImagePopup').onclick = function() {
        renderPopupImageList();
        openPopUp('imagePopup');
    };

    document.getElementById('closeImagePopup').onclick = function() {
        closePopUp('imagePopup');
        renderMainImagePreview();
    };
    document.getElementById('closePopupCross').onclick = function() {
        closePopUp('imagePopup');
    };

    document.getElementById('popupUploadInput').onchange = function(e) {
        const files = Array.from(e.target.files);
        if (selectedFiles.length + files.length > 5) {
            alert("Vous pouvez sélectionner jusqu'à 5 images maximum.");
            return;
        }
        files.forEach(file => {
            if (selectedFiles.length < 5) selectedFiles.push(file);
        });
        renderPopupImageList();
        e.target.value = ""; // reset input
    };

    function renderPopupImageList() {
        const list = document.getElementById('popupImageList');
        list.innerHTML = "";
        selectedFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = "popup-img-item";
                div.innerHTML = `
                    <img src="${event.target.result}" alt="Image" />
                    <button type="button" class="remove-img-btn" data-idx="${idx}">✖</button>
                `;
                div.querySelector('.remove-img-btn').onclick = function() {
                    selectedFiles.splice(idx, 1);
                    renderPopupImageList();
                };
                list.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        document.querySelector('.add-image-btn').style.display = selectedFiles.length < 5 ? "inline-block" : "none";
    }

    function renderMainImagePreview() {
        const preview = document.getElementById('mainImagePreview');
        preview.innerHTML = "";
        selectedFiles.forEach(file => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = "main-img-preview";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    // Ajoute les images à formData lors de l’envoi
    async function submitActivityData() {
        try {
            const formData = new FormData();
            formData.append('titre', document.getElementById('nom').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('mobiliteReduite', document.getElementById('mobiliteReduite').checked ? 1 : 0);
            formData.append('adresse', document.getElementById('adresse').value);
                formData.append(
                    'dates',
                    Array.from(document.querySelectorAll('#datesAjoutees .theme-badge'))
                    .map(badge => badge.textContent.replace('✖', '').trim())
                    .join(', ')
                );
            formData.append('tailleGroupe', document.getElementById('nbPersonnes').value);
            formData.append('prix', document.getElementById('prix').value);

            // Récupérer les thèmes sélectionnés (IDs)
            const themes = Array.from(document.querySelectorAll('#themesAjoutes .theme-badge')).map(badge => badge.dataset.id);
            console.log("IDs des thèmes envoyés :", themes);
                if (themes.length > 0) {
                    formData.append('theme', themes[0]);
                }

            // Ajouter les images
            for (const file of selectedFiles) {
                formData.append('images[]', file);
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
                window.location.href = '../Page/accueil.php';
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
            const themes = Array.from(document.querySelectorAll('#themesAjoutes .theme-badge'));
            if (themes.length === 0) {
                alert("Veuillez sélectionner au moins un thème pour l'activité.");
                return; // Bloque l'envoi
            }
        submitActivityData();
    });

    // Fetch categories on page load
    window.onload = fetchCategories;
});
</script>
<script src="../Script/InfoPerso.js"></script>

<!-- Popup Upload Images -->
<div id="overlay" style="display:none;"></div>
<div id="imagePopup" class="popup-upload" style="display:none;">
    <button type="button" id="closePopupCross" class="close-popup-cross" style="position:absolute;top:10px;right:10px;font-size:1.5rem;background:none;border:none;cursor:pointer;">✖</button>
    <h2>Ajouter des images</h2>
    <div class="image-list" id="popupImageList"></div>
    <label class="add-image-btn">
        <input type="file" id="popupUploadInput" accept="image/*" style="display:none;" />
        <span>+</span>
    </label>
    <button type="button" id="closeImagePopup" class="close-popup-btn">Valider</button>
</div>


</body>
</html>