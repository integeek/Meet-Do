const table = document.getElementById("tableauCorps");
const next = document.getElementById("next-page");
const back = document.getElementById("prev-page");
const select = document.getElementsByClassName("select-search")[0];
const nombreClient = document.getElementById("clientNumber");
const searchInput = document.getElementsByClassName("search-input")[0];
const close = document.getElementsByClassName("close");
const modal = document.getElementsByClassName("modal");
const deleteBtn = document.getElementById("deleteBtn");
const answerBtn = document.getElementById("answerBtn");
const cancelBtn = document.getElementById("cancelBtn");
const sendBtn = document.getElementById("sendBtn");
let page = 1;
let ligneMax = 5;
let pageData = [];
let search = "";

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Admin/MessagerieAdminControlleur.php?search=${search}`, true);
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

const deleteMessage = (id) => {
    var request = new XMLHttpRequest();
    request.open("DELETE", `../../controller/Admin/MessagerieAdminControlleur.php?id=${id}`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                console.log(responseData, "responseData");
                Refresh();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const sendMessage = (message) => {
    var request = new XMLHttpRequest();
    request.open("POST", `../../controller/Admin/MessagerieAdminControlleur.php`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(JSON.stringify(message));
}

const setModal2 = (message) => {
    const message2 = document.getElementById("message");
    const answerMessage = document.getElementById("answerMessage");
    answerMessage.innerHTML = "";
    message2.innerHTML = message.message;

    cancelBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal[1].style = "animation: close 0.2s forwards;";
        setTimeout(() => {
            modal[1].classList.add("hidden");
            modal[0].classList.remove("hidden");
            modal[0].style = "animation: show 0.2s forwards;"
        }, 200);
    });

    sendBtn.addEventListener("click", (e) => {
        e.preventDefault();
        sendMessage({
            message: answerMessage.value,
            userName: `${message.nom} ${message.prenom}`,
            sujet: message.sujet,
            email: message.email,
            id: message.id
        });
        modal[1].style = "animation: close 0.2s forwards;";
        setTimeout(() => {
            modal[1].classList.add("hidden");
            answerMessage.value = "";
            Refresh();
        }, 200);
    });
}

const setModal = (message) => {
    const userMessage = document.getElementById("userMessage");
    const userName = document.getElementById("userName");
    const userEmail = document.getElementById("userEmail");
    const userTitle = document.getElementById("userTitle");

    userMessage.innerHTML = message.message;
    userName.innerHTML = `${message.nom} ${message.prenom}`;
    userEmail.innerHTML = message.email;
    userTitle.innerHTML = message.sujet;

    deleteBtn.addEventListener("click", (e) => {
        e.preventDefault();
        deleteMessage(message.id);
        modal[0].style = "animation: close 0.2s forwards;";
        setTimeout(() => {
            Array.from(modal).forEach((el2) => {
                el2.classList.add("hidden");
            });
            Refresh();
        }, 200);
    });

    answerBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal[0].style = "animation: close 0.1s forwards;";
        setModal2(message);
        setTimeout(() => {
            modal[0].classList.add("hidden");
            modal[1].classList.remove("hidden");
            modal[1].style = "animation: show 0.1s forwards;"
        }, 200);
    });
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

const renderTable = () => {
    table.innerHTML = "";
    pageData[page - 1].forEach((message) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${message.nom}</td>
            <td>${message.prenom}</td>
            <td>${message.email}</td>
            <td>${message.sujet}</td>
            <td>${message.dateEnvoie}</td>
            <td style="text-align: center;" id="open-${message.id}"><img src="../assets/img/icons/openFilled-icon.svg" alt="open" style="margin: 0 auto;" class="actions-icons"></td>
        `;
        table.appendChild(row);
        document.getElementById(`open-${message.id}`).addEventListener("click", () => {
            setModal(message);
            modal[0].classList.remove("hidden");
            modal[0].style = "animation: show 0.2s forwards;"
        });
    });
}

const Pagination = (data) => {
    pageData = [];
    for (let i = 0; i < data.length; i += ligneMax) {
        pageData.push(data.slice(i, i + ligneMax));
    }
    RenderPagination();
}

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

next.addEventListener("click", () => {
    console.log("next");
    Next();
});

back.addEventListener("click", () => {
    Back();
});

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

Array.from(close).forEach((el) => {
    el.addEventListener("click", () => {
        Array.from(modal).forEach((el2) => {
            el2.style = "animation: close 0.2s forwards;";
            setTimeout(() => {
                el2.classList.add("hidden");
            }, 200);
        });
    });
});

Refresh();