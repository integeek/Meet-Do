const table = document.getElementById("tableauCorps");
const next = document.getElementById("next-page");
const back = document.getElementById("prev-page");
const select = document.getElementsByClassName("select-search")[0];
const nombreClient = document.getElementById("clientNumber");
const searchInput = document.getElementsByClassName("search-input")[0];
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

Refresh();

const renderTable = () => {
    table.innerHTML = "";
    pageData[page - 1].forEach((message) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${message.nom}</td>
            <td>${message.prenom}</td>
            <td>${message.date}</td>
            <td style="text-align: center;"><img src="../assets/img/icons/openFilled-icon.svg" alt="open" style="margin: 0 auto;"></td>
            <td>
                <div class="icon-actions">
                    <img src="../assets/img/icons/eye-open-icon.svg" alt="">
                    <img src="../assets/img/icons/edit-icon.svg" alt="">
                    <img src="../assets/img/icons/icon-trash.svg" alt="">
                </div>
            </td>
        `;
        table.appendChild(row);
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