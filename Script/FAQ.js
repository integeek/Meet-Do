const data = [
    {
        id: 1,
        question:"J'ai oublié mon mot de passe, comment le récupérer ?",
        answer:"Pour récupérer votre mot de passe, veuillez cliquer sur le bouton 'Mot de passe oublié' situé sur la page de connexion. <br/> Un email vous sera envoyé pour réinitialiser votre mot de passe. <br/> Si vous ne recevez pas d'email, veuillez vérifier vos spams. <br/> Si vous n'avez pas reçu d'email, veuillez contacter le support.",
        theme: "Connexion"
    },
    {
        id: 2,
        question:"Comment changer mon mot de passe ?",
        answer:"Pour changer votre mot de passe, veuillez vous rendre sur votre profil et cliquer sur 'Modifier le mot de passe'.",
        theme: "Connexion"
    },
    {
        id: 3,
        question:"Comment supprimer mon compte ?",
        answer:"Pour supprimer votre compte, veuillez vous rendre sur votre profil et cliquer sur 'Supprimer le compte'.",
        theme: "Connexion"
    },
    {
        id: 4,
        question:"Comment contacter le support ?",
        answer:"Pour contacter le support, veuillez vous rendre sur la page de contact et remplir le formulaire.",
        theme: "Connexion"
    },
    {
        id: 5,
        question:"Comment ajouter un ami ?",
        answer:"Pour ajouter un ami, veuillez vous rendre sur la page de profil de l'utilisateur et cliquer sur 'Ajouter en ami'.",
        theme: "Connexion"
    },
    {
        id: 6,
        question:"Comment créer un groupe ?",
        answer:"Pour créer un groupe, veuillez vous rendre sur la page de groupe et cliquer sur 'Créer un groupe'.",
        theme: "Groupe"
    },
    {
        id: 7,
        question:"Comment rejoindre un groupe ?",
        answer:"Pour rejoindre un groupe, veuillez vous rendre sur la page de groupe et cliquer sur 'Rejoindre un groupe'.",
        theme: "Groupe"
    },
    
];

const themes = ["Themes", "Connexion", "Groupe", "Profil", "Paramètres"];

const container = document.querySelector('.collapse-container');
const newQeustion = document.querySelector('#new-question-button');
let theme = "";

const Theme = () => {
  select.innerHTML = themes.map((item, index) => {
      return `
      <option value="${item}" ${index === 0 ? "disabled selected" : ""}>${item}</option>
      `;
  }).join('');
}

Theme();

container.innerHTML = data.map((item, index) => {
    return `
    <div class="${index % 2 === 0 ? "collapse-left" : "collapse-right"}">
        <button type="button" class="collapse-title alone" id="${item.id}btn">
            <h3>${item.question}</h3>
            <div class="grow"></div>
            <image onclick="openPopUp1()" class="pen" src="../assets/img/pen.png" id="${
              item.id
            }img-pen"></image>
            <image class="trash" src="../assets/img/trash.png" id="${
              item.id
            }img-trash"></image>
            <image class="chevron" src="../assets/img/chevron.png" id="${
              item.id
            }img"></image>
        </button>
        <div class="collapse-content hidden" id="${item.id}p">
            <p>${item.answer}</p>
        </div>
    </div>
    `;
  })
  .join("");

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
      ThemeSelected();
  });
}

Selector();

const ThemeSelected = () => {
  const croixselected = document.querySelector('#croix-selected');
  console.log(croixselected, "croixselected");
  croixselected?.addEventListener('click', () => {
      document.getElementById('select-div').innerHTML = `
          <select id="select"></select>
      `;
      let select = document.querySelector('#select');
      select.selectedIndex = 0;
      theme = "";
      Theme();
      Selector();
  });
}

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
