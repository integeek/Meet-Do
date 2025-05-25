const user = document.getElementById("client-container-content");
const activity = document.getElementById("activity-container-content");
console.log(user, "user");
console.log(activity, "activity");
//theme = ["Sport", "Culture", "Cuisine", "Extérieur", "Intérieur", "Équipe", "Bien-être", "Nautique", "Dégustation", "Historique", "Visite", "Concert", "Jeux", "Enfants", "VR", "Animalier", "Aérien"];

let dataPie = {
    labels: [],
    datasets: [{
        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"], // Couleurs par défaut
        data: []
    }]
};

let dataLine = {
    labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"], // Mois de l'année
    datasets: [{
        label: "Activités",
        backgroundColor: "#36A2EB",
        borderColor: "#36A2EB",
        fill: false,
        data: []
    }]
};

let myChart;
let myChart2;

const AddGraphic = () => {

    if (myChart) {
        myChart.destroy();
    }
    if (myChart2) {
        myChart2.destroy();
    }

    myChart = new Chart("myChart", {
        type: "pie",
        data: dataPie,
        options: {
            title: {
                display: true,
                text: "Répartition des activités les plus populaires sur Meet&Do",
                fontSize: 16,
                fontColor: "#000",
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#000",
                }
            },
        }
    });

    myChart2 = new Chart("myChart2", {
        type: "line",
        data: dataLine,
        options: {
            title: {
                display: true,
                text: "Evolution du nombre d'activités publiées sur Meet&Do",
                fontSize: 16,
                fontColor: "#000",
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#000",
                }
            },
        }
    });
}

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/TableauBord/TableauBordControlleur.php`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                console.log(responseData);
                data = responseData;
                if (data.nombreActiviteTheme && Array.isArray(data.nombreActiviteTheme)) {
                    data.nombreActiviteTheme.forEach(element => {
                        dataPie.labels.push(element.activity || "Inconnu"); // Gérer les valeurs nulles
                        dataPie.datasets[0].data.push(element.number || 0);
                    });
                }

                if (data.nombreActiviteParMois && Array.isArray(data.nombreActiviteParMois)) {
                    const mois = data.nombreActiviteParMois[0]; // Premier élément du tableau
                    if (mois) {
                        dataLine.datasets[0].data = [
                            mois.janvier, mois.fevrier, mois.mars, mois.avril,
                            mois.mai, mois.juin, mois.juillet, mois.aout,
                            mois.septembre, mois.octobre, mois.novembre, mois.decembre
                        ].map(val => parseInt(val) || 0); // Convertir en nombres
                    }
                }
                user.textContent = data.nombreClient[0].number;
                activity.textContent = data.nombreActivite[0].number;
                AddGraphic();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

Refresh();