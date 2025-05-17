const table = document.getElementById("tableauCorps");
const next = document.getElementById("next-page");
const back = document.getElementById("prev-page");
const select = document.getElementsByClassName("select-search")[0];
const nombreClient = document.getElementById("clientNumber");
const searchInput = document.getElementsByClassName("search-input")[0];
const close = document.getElementById("closeModal");
const modal = document.getElementsByClassName("modal")[0];
const buttonBlock = document.getElementById("blockBtn");
const buttonDelete = document.getElementById("deleteBtn");
let idMeeter = 0;
let idClient = 0;
let Meeter = {};
let page = 1;
let ligneMax = 5;
let pageData = [];
let search = "";

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Admin/DemandeMeeter.php?search=${search}`, true);
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

const RefuseMeeter = () => {
    var request = new XMLHttpRequest();
    request.open("DELETE", `../../controller/Admin/DeleteNewMeeter.php`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const body = JSON.stringify({
        idMeeter: idMeeter,
    });

    request.send(body);
}

const AcceptMeeter = () => {
    var request = new XMLHttpRequest();
    request.open("POST", `../../controller/Admin/NewMeeter.php`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const body = JSON.stringify({
        idClient: idClient,
        idMeeter: idMeeter,
        telephone: Meeter.telephone,
        adresse: Meeter.adresse,
        description: Meeter.description,
    });

    request.send(body);
};


buttonBlock.addEventListener("click", (e) => {
    e.preventDefault();
    AcceptMeeter();
    modal.style = "animation: close 0.2s forwards;"
    setTimeout(() => {
        modal.classList.add("hidden");
        Refresh();
    }, 200);
});

buttonDelete.addEventListener("click", (e) => {
    e.preventDefault();
    RefuseMeeter();
    modal.style = "animation: close 0.2s forwards;"
    setTimeout(() => {
        modal.classList.add("hidden");
        Refresh();
    }, 200);
});

const setModal = (message) => {
    const userName = document.getElementById("userName");
    const userAdress = document.getElementById("userAdress");
    const description = document.getElementById("description");
    const userPhone = document.getElementById("userPhone");

    userName.innerHTML = message.nom + " " + message.prenom;
    userAdress.innerHTML = message.adresse;
    userPhone.innerHTML = message.telephone;
    description.innerHTML = message.description;
    idMeeter = message.id;
    idClient = message.idClient;
    Meeter = message;
}

Refresh();

const renderTable = () => {
    table.innerHTML = "";
    pageData[page - 1].forEach((message) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${message.nom}</td>
            <td>${message.prenom}</td>
            <td>${message.date}</td>
            <td style="text-align: center;" id="open-${message.id}"><img src="../assets/img/icons/openFilled-icon.svg" alt="open" style="margin: 0 auto;"></td>
        `;
        table.appendChild(row);
        document.getElementById(`open-${message.id}`).addEventListener("click", () => {
            setModal(message);
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