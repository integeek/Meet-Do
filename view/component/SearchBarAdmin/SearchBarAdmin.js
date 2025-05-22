function SearchBarAdmin(texte){
    return `
                <div class="search-number">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Rechercher">
                        <img class="search-icon" src="../assets/img/icons/search-icon.svg" alt="">
                    </div>
                    <div class="grow"></div>
                    <select class="select-search">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div class="client-count">
                        Nombre de ${texte} : <span id="clientNumber">10</span>
                    </div>
                </div>
    `
}