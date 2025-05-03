const themes = ["Themes", "Connexion", "Groupe", "Profil", "Paramètres"];

const container = document.querySelector('.collapse-container');
const newQeustion = document.querySelector('#new-question-button');
let theme = "";

var request = new XMLHttpRequest();
request.open("GET", "../../controller/Faq/Faq.php?sortBy=test", true);
request.send();

request.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    try {
      // Parse the JSON response
      const responseData = JSON.parse(this.responseText);
      console.log(responseData, "data"); // Log the parsed data

      // Replace the existing data with the new data
      data = responseData;

      // Re-render the container with the new data
      renderFaqContent();
    } catch (error) {
      console.error("Error parsing JSON response:", error);
    }
  } else if (this.readyState == 4) {
    console.error("Error: Unable to fetch data. Status:", this.status);
  }
};

const Theme = () => {
  select.innerHTML = themes.map((item, index) => {
      return `
      <option value="${item}" ${index === 0 ? "disabled selected" : ""}>${item}</option>
      `;
  }).join('');
}

Theme();

const renderFaqContent = () => {
  container.innerHTML = data
    .map((item, index) => {
      return `
      <div class="${index % 2 === 0 ? "collapse-left" : "collapse-right"}">
          <button type="button" class="collapse-title alone" id="${item.idFaq}btn">
              <h3>${item.question}</h3>
              <div class="grow"></div>
              <image onclick="openPopUp1()" class="pen" src="../assets/img/pen.png" id="${
                item.idFaq
              }img-pen"></image>
              <image class="trash" src="../assets/img/trash.png" id="${
                item.idFaq
              }img-trash"></image>
              <image class="chevron" src="../assets/img/chevron.png" id="${
                item.idFaq
              }img"></image>
          </button>
          <div class="collapse-content hidden" id="${item.idFaq}p">
              <p>${item.reponse}</p>
          </div>
      </div>
      `;
    })
    .join("");

  attachEventListeners();
};

const attachEventListeners = () => {
  data.forEach((item) => {
    const button = document.getElementById(`${item.idFaq}btn`);
    const content = document.getElementById(`${item.idFaq}p`);
    const chevron = document.getElementById(`${item.idFaq}img`);
    const pen = document.getElementById(`${item.idFaq}img-pen`);
    const trash = document.getElementById(`${item.idFaq}img-trash`);

    button.addEventListener("click", () => {
      content.classList.toggle("hidden");
      button.classList.toggle("alone");
      chevron.style.transform =
        (chevron.style.transform === "") |
        (chevron.style.transform === "rotate(0deg)")
          ? "rotate(180deg)"
          : "rotate(0deg)";
    });

    trash.addEventListener("click", () => {
      if (confirm("Voulez-vous vraiment supprimer cette question ?")) {
        console.log("Suppression de la question" + item.idFaq);
      } else {
        console.log("Annulation de la suppression");
      }
      content.classList.toggle("hidden");
      button.classList.toggle("alone");
      chevron.style.transform =
        (chevron.style.transform === "") |
        (chevron.style.transform === "rotate(0deg)")
          ? "rotate(180deg)"
          : "rotate(0deg)";
    });

    pen.addEventListener("click", () => {
      console.log("Modification de la question" + item.idFaq);
      content.classList.toggle("hidden");
      button.classList.toggle("alone");
      chevron.style.transform =
        (chevron.style.transform === "") |
        (chevron.style.transform === "rotate(0deg)")
          ? "rotate(180deg)"
          : "rotate(0deg)";
    });
  });
};

renderFaqContent();

newQeustion.addEventListener("click", () => {
  console.log("Ajout d'une nouvelle question");
});

function openPopUp() {
  document.getElementById("popup").style.display = "block";
}

function closePopUp() {
  document.getElementById("popup").style.display = "none";
}

function openPopUp1() {
  document.getElementById("popup1").style.display = "block";
}

function closePopUp1() {
  document.getElementById("popup1").style.display = "none";
}