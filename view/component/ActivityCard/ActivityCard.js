class ActivityCard {
    constructor(containerId, data) {
        this.container = document.getElementById(containerId);
        this.data = data;
        this.render();
    }

    render() {
        const card = document.createElement("div");
        card.classList.add("activity-card");
        card.onclick = () => window.location.href = `../../view/Page/Activite.php?id=${this.data.idActivite}`;

        card.innerHTML = `
            <div class="card">
                <img src="${this.data.chemin ?? '../../view/assets/img/placeholder.png'}" alt="Image de l'activité" class="card-img">
                <div class="card-content">
                    <h2 class="card-title">${this.data.titre}</h2>
                    <p><strong>Lieu :</strong> ${this.data.adresse}</p>
                    <p><strong>Prix :</strong> ${this.data.prix}€</p>
                    <p><strong>Groupe de :</strong> ${this.data.tailleGroupe} 👤</p>
                </div>
            </div>
        `;

        this.container.appendChild(card);
    }
}

let offset = 0;
const limit = 6;
let loading = false;
let noMoreData = false;

function loadActivities() {
    if (loading || noMoreData) return;
    loading = true;
    document.getElementById("loader").style.display = "block";

    fetch(`../../controller/Accueil/getActivities.php?offset=${offset}`)
        .then(response => response.json())
        .then(activities => {
            if (activities.length === 0) {
                noMoreData = true;
                if (offset === 0) {
                    const container = document.getElementById("activities-container");
                    container.innerHTML = "<p>Aucune activité pour le moment.</p>";
                }
                return;
            }

            activities.forEach(activityData => new ActivityCard("activities-container", activityData));
            offset += limit;
        })
        .catch(error => console.error("Erreur lors du chargement des activités :", error))
        .finally(() => {
            loading = false;
            document.getElementById("loader").style.display = "none";
        });
}

document.addEventListener("DOMContentLoaded", () => {
    loadActivities();

    window.addEventListener("scroll", () => {
        const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 300;
        if (nearBottom) loadActivities();
    });
});
