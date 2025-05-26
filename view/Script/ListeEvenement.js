const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('idActivite');

let page = 1;
let ligneMax = 15;
let pageData = [];
let evenements = [];

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Activite/ListeEvenementControlleur.php?action=liste&id=${id}`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                evenements = responseData.evenements || [];
                Pagination(evenements);
                renderTable();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
};

const Pagination = (data) => {
    pageData = [];
    for (let i = 0; i < data.length; i += ligneMax) {
        pageData.push(data.slice(i, i + ligneMax));
    }
    RenderPagination();
};

const RenderPagination = () => {
    const container = document.querySelector(".pagination-pages");
    container.innerHTML = "";
    for (let i = 1; i <= pageData.length; i++) {
        const btn = document.createElement("button");
        btn.className = "pagination-page" + (i === page ? " active" : "");
        btn.textContent = i;
        btn.addEventListener("click", () => {
            page = i;
            renderTable();
            RenderPagination();
        });
        container.appendChild(btn);
    }
};

const renderTable = () => {
    const table = document.getElementById("tableauCorps");
    table.innerHTML = "";
    if (pageData.length === 0) return;
    pageData[page - 1].forEach((evt) => {
        // Séparation date/heure
        const [date, heure] = evt.dateEvenement.split(' ');
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${evt.titre}</td>
            <td>${date}</td>
            <td>${heure}</td>
            <td>
                <a href="ListeAttente.php?idEvenement=${evt.idEvenement}">
                    <img src="../assets/img/icons/openFilled-icon.svg" alt="voir" class="actions-icons">
                </a>
            </td>
        `;
        table.appendChild(row);
    });
};

document.getElementById("next-page").addEventListener("click", () => {
    if (page < pageData.length) {
        page++;
        renderTable();
        RenderPagination();
    }
});
document.getElementById("prev-page").addEventListener("click", () => {
    if (page > 1) {
        page--;
        renderTable();
        RenderPagination();
    }
});

Refresh();