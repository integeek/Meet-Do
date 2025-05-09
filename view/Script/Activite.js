document.addEventListener("DOMContentLoaded", () => {
    fetch("../../controller/Activite/Activite.php?idActivite=7")
        .then(res => res.json())
        .then(data => {
            const datesDisponibles = data.datesDisponibles;
            const horairesParDate = {};

            data.horairesParDate.forEach(e => {
                if (!horairesParDate[e.dateEvenement]) {
                    horairesParDate[e.dateEvenement] = [];
                }
                horairesParDate[e.dateEvenement].push({
                    heure: e.heure,
                    inscrits: parseInt(e.inscrits),
                    max: parseInt(e.max)
                });
            });
            console.log(data);


            flatpickr("#datepicker", {
                enable: datesDisponibles,
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr) {
                    afficherCreneaux(dateStr, horairesParDate);
                }
            });
        });

    function afficherCreneaux(date, horairesParDate) {
        const creneaux = horairesParDate[date] || [];
        const container = document.getElementById("creneaux-container");
        container.innerHTML = "";

        if (creneaux.length === 0) {
            container.innerHTML = "<p>Aucun créneau disponible pour cette date.</p>";
            return;
        }

        creneaux.forEach(c => {
            const btn = document.createElement("div");
            btn.classList.add("creneau-btn");

            if (c.inscrits >= c.max) {
                btn.classList.add("full");
            }

            btn.innerHTML = `
                <span class="creneau-time">${c.heure}</span>
                <span class="creneau-capacity">${c.inscrits}/${c.max} personnes</span>
            `;

            if (c.inscrits < c.max) {
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".creneau-btn").forEach(el => el.classList.remove("selected"));
                    btn.classList.add("selected");
                    console.log("Créneau sélectionné :", c.heure);
                });
            }

            container.appendChild(btn);
        });
    }
});

const btn = document.getElementById("boutonBleuPop");
let connected = false;

const UserInfo = () => {
    var request = new XMLHttpRequest();
    request.open("GET", "./../../controller/Navbar/Navbar.php", true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                console.log(responseData, "test");
                if (responseData.success) {
                    console.log("connecté");
                    connected = true;
                } else {
                    console.error("Error:", responseData.message);
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

UserInfo();

btn.addEventListener("click", () => {
    if (!connected) {
        window.location.href = "./../../view/Page/Connexion.php";
    } 
})
