function SearchBarAdmin(texte){
    return `
    <div class="search-number">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Rechercher">
                        <img class="search-icon" src="../assets/img/icons/search-icon.svg" alt="">
                    </div>
                    <div class="client-count">
                        Nombre de ${texte} : <span id="clientNumber">10</span>
                    </div>
                </div>
    `
}