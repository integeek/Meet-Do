document.addEventListener("DOMContentLoaded", () => {
    const datesDisponibles = ["2025-05-05", "2025-05-08", "2025-05-12"];

    const horairesParDate = {
        "2025-05-05": [
            { heure: "9h30-10h30", inscrits: 10, max: 10 },
            { heure: "10h30-11h30", inscrits: 5, max: 10 },
            { heure: "12h30-13h30", inscrits: 0, max: 10 },
            { heure: "14h30-15h30", inscrits: 3, max: 10 },
            { heure: "15h30-16h30", inscrits: 4, max: 10 },
        ],
        "2025-05-08": [
            { heure: "10h00-11h00", inscrits: 7, max: 10 },
            { heure: "11h30-12h30", inscrits: 10, max: 10 },
        ],
        "2025-05-12": [
            { heure: "13h00-14h00", inscrits: 1, max: 10 },
        ]
    };

    flatpickr("#datepicker", {
        enable: datesDisponibles,
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            afficherCreneaux(dateStr);
        }
    });

    function afficherCreneaux(date) {
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
