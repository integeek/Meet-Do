function SearchBar(url) {
return `
    <div></div>
    <div class="search-bar">
        <input type="text" placeholder="Rechercher" id="search-input">
        <button id="search-btn"><img src="../assets/img/icons/search-icon.svg" alt=""></button>
        <div class="separator"></div>
        <button id="settings-btn"><img src="../assets/img/icons/settings.svg" alt=""></button>
        <button id="position-btn">
            <img src="../assets/img/icons/position-icon.svg" alt="">
        </button>
    </div>
    <!-- Modal Filtres -->
    <div id="filters-modal" class="popup hidden">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h3>Filtres</h3>
            <button id="close-filters" style="font-size:1.5rem;background:none;border:none;cursor:pointer;">✖</button>
        </div>
        <div style="margin:15px 0;">
            <label>Date : <input type="date" id="date"/></label>
        </div>
        <div style="margin:15px 0;">
            <label><input type="checkbox" id="pmr-filter"/> Accessible PMR</label>
        </div>
        <div id="categories-filter" style="display:flex;gap:10px;flex-wrap:wrap;"></div>
        <button id="apply-filters" style="margin-top:20px;">Appliquer</button>
    </div>
    <!-- Modal Map -->
    <div id="map-modal" class="popup hidden" style="width:80vw;max-width:700px;height:70vh;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h3>Carte des activités</h3>
                <div id="map-loading-indicator" style="display:flex;align-items:center;gap:8px;font-size:1rem;margin-top:2px;">
                    <span>Chargement des lieux...</span>
                    <img src="../../view/assets/img/loader.gif" alt="Chargement..." width="22" height="22">
                </div>
            </div>
            <button id="close-map" style="font-size:1.5rem;background:none;border:none;cursor:pointer;">✖</button>
        </div>
        <div id="map" style="width:100%;height:90%;margin-top:10px;border-radius:10px;position:relative;"></div>
    </div>
`;
}