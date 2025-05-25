function SearchBar(url) {
return `
        <div></div>
        <div class="search-bar">
            <input type="text" placeholder="Rechercher" id="search-input">
            <button><img src="../assets/img/icons/search-icon.svg" alt=""></button>
            <div class="separator"></div>
            <button><img src="../assets/img/icons/settings.svg" alt=""></button>
            <button id="position-btn">
                <img src="../assets/img/icons/position-icon.svg" alt="">
            </button>
            <div class="separator"></div>
            <button><input type="date" id="date"/></button>
        </div>

        <div id="position-popup" class="popup hidden">
                    <input class="textbox" type="text" name="adresse" id="adresse" placeholder="Entrez une adresse...">
                    <ul id="suggestions"></ul>
                    <button id="confirm-location">Oui</button>
                    <button id="cancel-location">Non</button>
        </div>
    `;
};