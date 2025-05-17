const table = document.getElementById("tableauCorps");
const next = document.getElementById("next-page");
const back = document.getElementById("prev-page");
const select = document.getElementsByClassName("select-search")[0];
const nombreClient = document.getElementById("clientNumber");
const searchInput = document.getElementsByClassName("search-input")[0];
const close = document.getElementById("closeModal");
const modal = document.getElementsByClassName("modal")[0];
const buttonUpdate = document.getElementById("submitBtn");
let idClient = 0;
let page = 1;
let ligneMax = 5;
let pageData = [];
let search = "";


const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Admin/GestionClients.php?search=${search}`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                data = responseData;
                console.log(data, "data");
                Pagination(data);
                renderTable();
                nombreClient.innerHTML = data.length;
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const Pagination = (data) => {
    pageData = [];
    for (let i = 0; i < data.length; i += ligneMax) {
        pageData.push(data.slice(i, i + ligneMax));
    }
    RenderPagination();
}

const RenderPagination = () => {
    const paginationContainer = document.getElementsByClassName("pagination-pages")[0];
    paginationContainer.innerHTML = "";
    for (let i = 1; i <= pageData.length; i++) {
        const btn = document.createElement("button");
        btn.className = "pagination-page" + (i === page ? " active" : "");
        btn.id = `btn-${i}`;
        btn.textContent = i;
        btn.addEventListener("click", () => {
            page = i;
            renderTable();
            RenderPagination();
        });
        paginationContainer.appendChild(btn);
    }
}

next.addEventListener("click", () => {
    console.log("next");
    Next();
});

back.addEventListener("click", () => {
    Back();
});

const Next = () => {
    if (page < pageData.length) {
        page++;
        renderTable();
        RenderPagination();
    }
}

const Back = () => {
    if (page > 1) {
        page--;
        renderTable();
        RenderPagination();
    }
}

const UpdateClient = () => {
    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const role = document.getElementById("role");

    var request = new XMLHttpRequest();
    request.open("POST", `../../controller/Admin/UpdateClient.php`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const body = JSON.stringify({
        idClient: idClient,
        nom: nom.value,
        prenom: prenom.value,
        role: role.value
    });

    request.send(body);
};

const setModal = (client) => {
    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const email = document.getElementById("email");
    const role = document.getElementById("role");

    nom.value = client.nom;
    prenom.value = client.prenom;
    email.value = client.email;
    role.value = client.role;
    idClient = client.id;
}

buttonUpdate.addEventListener("click", (e) => {
    e.preventDefault();
    UpdateClient();
    modal.style = "animation: close 0.2s forwards;"
    setTimeout(() => {
        modal.classList.add("hidden");
        Refresh();
    }, 200);
});

Refresh();

const renderTable = () => {
    table.innerHTML = "";
    pageData[page - 1].forEach((client) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${client.nom}</td>
            <td>${client.prenom}</td>
            <td>${client.email}</td>
            <td>${client.role}</td>
            <td>
                <div class="icon-actions">
                    <img src="../assets/img/icons/edit-icon.svg" alt="" id="edit-${client.id}" class="actions-icons">
                    <img src="../assets/img/icons/icon-trash.svg" alt="" id="delete-${client.id}" class="actions-icons">
                </div>
            </td>
        `;
        table.appendChild(row);
        document.getElementById(`delete-${client.id}`).addEventListener("click", () => {
            const confirmDelete = confirm(`Êtes-vous sûr de vouloir supprimer ce ${client.nom} ${client.prenom} ?`);
            if (confirmDelete) {
                var request = new XMLHttpRequest();
                request.open("DELETE", `../../controller/Admin/DeleteClient.php?id=${client.id}`, true);
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                request.send(`id=${client.id}`);

                request.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        Refresh();
                    }
                };
            }
        });
        document.getElementById(`edit-${client.id}`).addEventListener("click", () => {
            setModal(client);
            modal.classList.remove("hidden");
            modal.style = "animation: show 0.2s forwards;"
        });
    });
}

select.addEventListener("change", (e) => {
    ligneMax = parseInt(e.target.value);
    page = 1;
    Refresh();
});

searchInput.addEventListener("input", (e) => {
    search = e.target.value;
    page = 1;
    Refresh();
});

close.addEventListener("click", () => {
    modal.style = "animation: close 0.2s forwards;"
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 200);
});