const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('idEvenement');
const activityName = document.getElementById("activity-name");
const activityDate = document.getElementById("activity-date");
const reservedPlaces = document.getElementById("reserved-places");
let pageParticipants = 1;
let pageAttente = 1;
let ligneMaxParticipants = 5;
let ligneMaxAttente = 5;
let pageDataParticipants = [];
let pageDataAttente = [];
let data = { participants: [], attente: [] };

const getEvenement = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Activite/ListeAttenteControlleur.php?id=${id}&action=event`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                evenement = responseData;
                Refresh();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    }
}

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Activite/ListeAttenteControlleur.php?action=liste&id=${id}`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                data = responseData;
                AddEvenementInfo();
                PaginationParticipants(data.participants);
                PaginationAttente(data.attente);
                renderTableParticipants();
                renderTableAttente();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const DeleteReservation = (idReservation) => {
    var request = new XMLHttpRequest();
    request.open("DELETE", `../../controller/Activite/ListeAttenteControlleur.php?action=delete&idReservation=${idReservation}`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                setTimeout(() => {
                    Refresh();
                }, 500);
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const AddEvenementInfo = () => {
    if (evenement) {
        activityName.textContent = evenement.titre;
        const date = new Date(evenement.dateEvenement.replace(' ', 'T'));
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const dateStr = date.toLocaleDateString('fr-FR', options);
        const timeStr = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', hour12: false });
        activityDate.textContent = `${dateStr} à ${timeStr}`;
        let reservePlace = 0;
        data.participants.forEach((participant) => {
            reservePlace += Number(participant.place);
        });
        reservedPlaces.textContent = `${reservePlace} / ${evenement.tailleGroupe}`;
    } else {
        console.error("Evenement data is not available.");
    }
}

const PaginationParticipants = (dataArray) => {
    pageDataParticipants = [];
    for (let i = 0; i < dataArray.length; i += ligneMaxParticipants) {
        pageDataParticipants.push(dataArray.slice(i, i + ligneMaxParticipants));
    }
    RenderPaginationParticipants();
};

const PaginationAttente = (dataArray) => {
    pageDataAttente = [];
    for (let i = 0; i < dataArray.length; i += ligneMaxAttente) {
        pageDataAttente.push(dataArray.slice(i, i + ligneMaxAttente));
    }
    RenderPaginationAttente();
};

const RenderPaginationParticipants = () => {
    const container = document.querySelector(".participants-container .pagination-pages");
    container.innerHTML = "";
    for (let i = 1; i <= pageDataParticipants.length; i++) {
        const btn = document.createElement("button");
        btn.className = "pagination-page" + (i === pageParticipants ? " active" : "");
        btn.textContent = i;
        btn.addEventListener("click", () => {
            pageParticipants = i;
            renderTableParticipants();
            RenderPaginationParticipants();
        });
        container.appendChild(btn);
    }
};

const RenderPaginationAttente = () => {
    const container = document.querySelector(".liste-attente-container .pagination-pages");
    container.innerHTML = "";
    for (let i = 1; i <= pageDataAttente.length; i++) {
        const btn = document.createElement("button");
        btn.className = "pagination-page" + (i === pageAttente ? " active" : "");
        btn.textContent = i;
        btn.addEventListener("click", () => {
            pageAttente = i;
            renderTableAttente();
            RenderPaginationAttente();
        });
        container.appendChild(btn);
    }
};

const renderTableParticipants = () => {
    const table = document.getElementById("tableauCorps");
    table.innerHTML = "";
    if (pageDataParticipants.length === 0) return;
    pageDataParticipants[pageParticipants - 1].forEach((participant) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${participant.nom}</td>
            <td>${participant.prenom}</td>
            <td>${participant.email}</td>
            <td>${participant.place}</td>
            <td>
                <image src="../assets/img/icons/icon-trash.svg" alt="delete" class="actions-icons" id="DeleteReservation${participant.idReservation}">
            </td>
        `;
        table.appendChild(row);
        document.getElementById(`DeleteReservation${participant.idReservation}`).addEventListener("click", () => {
            DeleteReservation(participant.idReservation);
        });
    });
};

const renderTableAttente = () => {
    const table = document.getElementById("list-attente-body");
    table.innerHTML = "";
    if (pageDataAttente.length === 0) return;
    pageDataAttente[pageAttente - 1].forEach((participant) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${participant.nom}</td>
            <td>${participant.prenom}</td>
            <td>${participant.email}</td>
            <td>${participant.place}</td>
            <td>
                <image src="../assets/img/icons/icon-trash.svg" alt="delete" class="actions-icons" id="DeleteReservation${participant.idReservation}">
            </td>
        `;
        table.appendChild(row);
        document.getElementById(`DeleteReservation${participant.idReservation}`).addEventListener("click", () => {
            DeleteReservation(participant.idReservation);
        });
    });
};

document.getElementById("next-page").addEventListener("click", () => {
    if (pageParticipants < pageDataParticipants.length) {
        pageParticipants++;
        renderTableParticipants();
        RenderPaginationParticipants();
    }
});
document.getElementById("prev-page").addEventListener("click", () => {
    if (pageParticipants > 1) {
        pageParticipants--;
        renderTableParticipants();
        RenderPaginationParticipants();
    }
});

document.getElementById("next-page2").addEventListener("click", () => {
    if (pageAttente < pageDataAttente.length) {
        pageAttente++;
        renderTableAttente();
        RenderPaginationAttente();
    }
});
document.getElementById("prev-page2").addEventListener("click", () => {
    if (pageAttente > 1) {
        pageAttente--;
        renderTableAttente();
        RenderPaginationAttente();
    }
});

getEvenement();