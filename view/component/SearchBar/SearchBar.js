function SearchBar(url) {
return `
        <div></div>
        <div class="search-bar">
            <input type="text" placeholder="Rechercher" id="search-input">
            <button><img src="../assets/img/icons/search-icon.svg" alt=""></button>
            <div class="separator"></div>
            <button><img src="../assets/img/icons/settings.svg" alt=""></button>
            <button><img src="../assets/img/icons/position-icon.svg" alt=""></button>
            <div class="separator"></div>
            <button><input type="date" id="date"/></button>
        </div>
    `;
};