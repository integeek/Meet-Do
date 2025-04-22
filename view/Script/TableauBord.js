const myChart = new Chart("myChart", {
    type: "pie",
    data: {
        labels: ["Visiteurs", "Clients"],
        datasets: [{
            backgroundColor: ["#FF6384", "#36A2EB"],
            data: [200, 80]
        }]
    },
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

const myChart2 = new Chart("myChart2", {
    type: "line",
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [{
            label: "Visiteurs",
            backgroundColor: "#FF6384",
            data: [0, 10, 5, 2, 20, 30, 45]
        }, {
            label: "Clients",
            backgroundColor: "#36A2EB",
            data: [0, 5, 10, 15, 20, 25, 30]
        }]
    },
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