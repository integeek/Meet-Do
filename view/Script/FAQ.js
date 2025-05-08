const themes = ["Theme", "comptes", "reservations", "reglements", "bugs"];

const container = document.querySelector('.collapse-container');
const newQeustion = document.querySelector('#new-question-button');
let theme = "";


const Refresh = () => {
  var request = new XMLHttpRequest();
  request.open("GET", `../../controller/Faq/Faq.php?sortBy=${theme}`, true);
  request.send();

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const responseData = JSON.parse(this.responseText);
        console.log(responseData);
        data = responseData;
        renderFaqContent();
      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }
    } else if (this.readyState == 4) {
      console.error("Error: Unable to fetch data. Status:", this.status);
    }
  };
}

Refresh();

const Theme = () => {
  select.innerHTML = themes.map((item, index) => {
    return `
      <option value="${item}" ${index === 0 ? "disabled selected" : ""}>${item}</option>
      `;
  }).join('');
}

Theme();

const Selector = () => {
  const select = document.querySelector('#select');
  select?.addEventListener('change', (e) => {
    document.getElementById('select-div').innerHTML = `
            <div id="selected" >
               <p id="selected-text"></p>
                <img src="../assets/img/croix.png" alt="croix icon" id="croix-selected"/>
            </div>
        `;
    const selectedText = document.querySelector('#selected-text');
    theme = e.target.value;
    selectedText.innerHTML = theme;
    Refresh();
    ThemeSelected();
  });
}

Selector();

const ThemeSelected = () => {
  const croixselected = document.querySelector('#croix-selected');
  croixselected?.addEventListener('click', () => {
    document.getElementById('select-div').innerHTML = `
            <select id="select"></select>
        `;
    let select = document.querySelector('#select');
    select.selectedIndex = 0;
    theme = "";
    Theme();
    Selector();
    Refresh();
  });
}

const renderFaqContent = () => {
  console.log(data, "data");
  container.innerHTML = data
    .map((item, index) => {
      return `
      <div class="${index % 2 === 0 ? "collapse-left" : "collapse-right"}">
          <button type="button" class="collapse-title alone" id="${item.id}btn">
              <h3>${item.question}</h3>
              <div class="grow"></div>
              <image onclick="openPopUp1()" class="pen" src="../assets/img/pen.png" id="${item.id
        }img-pen"></image>
              <image class="trash" src="../assets/img/trash.png" id="${item.id
        }img-trash"></image>
              <image class="chevron" src="../assets/img/chevron.png" id="${item.id
        }img"></image>
          </button>
          <div class="collapse-content hidden" id="${item.id}p">
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
    const button = document.getElementById(`${item.id}btn`);
    const content = document.getElementById(`${item.id}p`);
    const chevron = document.getElementById(`${item.id}img`);
    const pen = document.getElementById(`${item.id}img-pen`);
    const trash = document.getElementById(`${item.id}img-trash`);

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
        console.log("Suppression de la question" + item.id);
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
      console.log("Modification de la question" + item.id);
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