class ActivityCard {
    constructor(containerId, data) {
      this.container = document.getElementById(containerId);
      this.data = data;
      this.render();
    }
  
    render() {
      const card = document.createElement("div");
      card.classList.add("activity-card");
      card.onclick = () => window.location.href = this.data.url;
  
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
    const activities = [
        {
        image: "https://www.chateaux-de-la-loire.fr/images/chateau-royal-de-chambord-en-ete.jpg",
        title: "Atelier Macaron",
        location: "10 rue de Vanves, 92130 Issy-Les-Moulineaux",
        price: 300,
        groupSize: 10,
        rating: 4.8,
        url : "http://localhost/view/Page/Activite.php"
        },
        {
            image: "https://www.chateaux-de-la-loire.fr/images/chateau-royal-de-chambord-en-ete.jpg",
            title: "Visite d’un chateau",
            location: "Avenue du Château, 41700, Cheverny",
            price: 154,
            groupSize: 25,
            rating: 3.7,
            url : "https://google.com"
        },
        {
            image: "https://cdn.paris.fr/qfapv4/2023/06/20/huge-be456d020506f4464615fcab9d1a00ef.jpg",
            title: "Cours de poterie",
            location: "28 Rue Notre Dame des Champs, 75006 Paris",
            price: 350,
            groupSize: 10,
            rating: 4.1,
            url : "https://google.com"
        },
        {
            image: "https://www.vertical-art.fr/wp-content/themes/vertical-art/video/vertical-cover-2021.jpg",
            title: "Escalade en Salle",
            location: "13 Avenue de la Plaine des Sports, 95000 Cergy",
            price: 15,
            groupSize: 20,
            rating: 3.5,
            url : "https://google.com"
            },
            {
                image: "https://img.freepik.com/photos-premium/appareil-photo-tridop-prend-photo-tour-eiffel-paris_174699-614.jpg",
                title: "Atelier Photo Paris",
                location: "Place Charles de Gaulle, 75008 Paris",
                price: 100,
                groupSize: 5,
                rating: 4.7,
                url : "https://google.com"
            },
            {
                image: "https://actualitte.com/uploads/images/un-guide-pour-creer-et-animer-un-club-de-lecture-63de34d65b713517872305.png",
                title: "Club de lecture",
                location: "Quai François Mauriac, 75706 Paris",
                price: 0,
                groupSize: 8,
                rating: 3.3,
                url : "https://google.com"
            }

    ];
  
    activities.forEach(activityData => new ActivityCard("activities-container", activityData));
  });
  