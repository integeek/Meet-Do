class ActivityCard {
  constructor(containerId, data) {
      this.container = document.getElementById(containerId);
      this.data = data;
      this.render();
  }

  render() {
      const card = document.createElement("div");
      card.classList.add("activity-card");

      // Redirige vers une page avec l’ID de l’activité
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

// Chargement dynamique depuis PHP
document.addEventListener("DOMContentLoaded", function () {
  fetch('../../controller/Accueil/getActivities.php')
        .then(response => response.json())
        .then(activities => {
            activities.forEach(activityData => new ActivityCard("activities-container", activityData));
        })
        .catch(error => console.error("Erreur lors du chargement des activités :", error));
});