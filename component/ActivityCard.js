class ActivityCard {
    constructor(containerId, data) {
      this.container = document.getElementById(containerId);
      this.data = data;
      this.render();
    }
  
    render() {
      const card = document.createElement("div");
      card.classList.add("activity-card");
  
      card.innerHTML = `
        <div class="card">
          <img src="${this.data.image}" alt="Image de l'activité" class="card-img">
          <div class="card-content">
            <h2 class="card-title">${this.data.title}</h2>
            <p><strong>Lieu :</strong> ${this.data.location}</p>
            <p><strong>Prix :</strong> ${this.data.price}€</p>
            <p><strong>Groupe de :</strong> ${this.data.groupSize} 👤</p>
            <p><strong>Note :</strong> ${this.data.rating}⭐</p>
          </div>
        </div>
      `;
  
      this.container.appendChild(card);
    }
  }
  
  // Exemple d'utilisation :
  document.addEventListener("DOMContentLoaded", function () {
    const activityData = {
      image: "https://via.placeholder.com/400x200", // Remplace avec l'URL réelle
      title: "Atelier Macaron",
      location: "10 rue de Vanves, 92130 Issy-Les-Moulineaux",
      price: 300,
      groupSize: 10,
      rating: 4.8
    };
  
    new ActivityCard("activities-container", activityData);
  });
  