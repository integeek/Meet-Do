    
const PaginationChange = () => {    
    console.log("Pagination function called");
    document.addEventListener("DOMContentLoaded", function () {
        const ligneMax = 10;
        let pageActuelle = 1;
        const tableauCorps = document.getElementById("tableauCorps");
        const ligne = Array.from(tableauCorps.getElementsByTagName("tr"));
        const totalPages = Math.ceil(ligne.length / ligneMax);

        document.getElementById("pagination-container").innerHTML = Pagination(totalPages);

        function AffichageTableau(page) {
            tableauCorps.innerHTML = "";
            let depart = (page - 1) * ligneMax;
            let fin = depart + ligneMax;
            let ligneTableau = ligne.slice(depart, fin);
            ligneTableau.forEach(ligneTab => tableauCorps.appendChild(ligneTab));

            let links = document.querySelectorAll(".link");
            links.forEach(link => link.classList.remove("active"));
            links[page - 1].classList.add("active");
        }

        window.changePage = function (page) {
            pageActuelle = page;
            AffichageTableau(pageActuelle);
        };

        window.backBtn = function () {
            if (pageActuelle > 1) {
                pageActuelle--;
                AffichageTableau(pageActuelle);
            }
        };

        window.nextBtn = function () {
            if (pageActuelle < totalPages) {
                currentPage++;
                AffichageTableau(pageActuelle);
            }
        };
        AffichageTableau(pageActuelle);
    });
}
