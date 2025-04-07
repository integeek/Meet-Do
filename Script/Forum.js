const data = [
    {
        id : 1,
        userName : "Jean Soleil",
        date : "2023-10-01",
        question : "Comment fonctionne le système de points ?",
        theme : "Connexion",
        answer : [
            {
                userName : "Jean Soleil",
                date : "2023-10-01",
                answer : "Le système de points fonctionne en attribuant des points aux utilisateurs en fonction de leur activité sur la plateforme. Plus vous êtes actif, plus vous gagnez de points."
            },
            {
                userName : "Marie Dupont",
                date : "2023-10-02",
                answer : "Merci pour l'info !"
            }
        ]
    },
    {
        id : 2,
        userName : "Marie Dupont",
        date : "2023-10-02",
        question : "Comment changer mon mot de passe ?",
        theme : "Connexion",
        answer : [
            {
                userName : "Jean Soleil",
                date : "2023-10-01",
                answer : "Pour changer votre mot de passe, allez dans les paramètres de votre compte."
            }
        ]
    },
    {
        id : 3,
        userName : "Pierre Martin",
        date : "2023-10-03",
        question : "Comment signaler un utilisateur ?",
        theme : "Groupe",
        answer : [
            {
                userName : "Marie Dupont",
                date : "2023-10-02",
                answer : "Pour signaler un utilisateur, cliquez sur le bouton 'Signaler' sur son profil."
            }
        ]
    }
]


const themes = [
    "Themes",
    "Connexion",
    "Groupe",
    "Profil",
    "Paramètres"
];

const newQuestion = document.querySelector('#new-question-button');
const buttonSend = document.querySelector('.collapse-add-button');
const container = document.querySelector('.collapse-container');
let theme = "";

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
    console.log(select);
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

newQuestion.addEventListener('click', () => {
    console.log("Ajout d'une nouvelle question");
});

container.innerHTML = data.map((item, index) => {
    return `
            <div class="collapse-right">
                <button type="button" class="collapse-title alone" id="${item.id}btn">
                    <div class="collapse-header">
                        <img src="../assets/img/profil.png" alt="profil icon" class="collapse-profil" />
                        <p>${item.userName}</p>
                        <div class="grow"></div>
                        <p>${item.date}</p>
                        <img src="../assets/img/more.png" alt="more icon" class="collapse-more" id="${item.id}more"/>
                    </div>
                    <div class="collapse-question">
                        <p>${item.question}</p>
                    </div>
                </button>
            </div>
            <div class="collapse-content hidden" id="${item.id}content">
                ${item.answer.map((answer, index) => {
                    return `
                        <div class="collapse-content-answer">
                            <img src="../assets/img/return.png" alt="return icon" class="collapse-return" />
                            <div class="collapse-header">
                                <img src="../assets/img/profil.png" alt="profil icon" class="collapse-profil" />
                                <p>${answer.userName}</p>
                                <div class="grow"></div>
                                <p>${answer.date}</p>
                                <img src="../assets/img/more.png" alt="more icon" class="collapse-more" />
                            </div>
                            <div></div>
                            <div class="collapse-question">${answer.answer}</div>
                        </div>
                    `
                }).join('')}
                <div class="collapse-add">
                    <button type="button" class="collapse-add-button" id="${item.id}add">
                        <p>Répondre</p>
                        <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
                    </button>
                </div>
            </div>
        </div>
    `;
}).join('');

data.forEach((item) => {
    const button = document.getElementById(`${item.id}btn`);
    const more = document.getElementById(`${item.id}more`);
    const add = document.getElementById(`${item.id}add`);

    add.addEventListener('click', () => {
        if (document.getElementById(`${item.id}texte`)) {
            document.getElementById(`${item.id}texte`).style = 'animation: send 1s forwards;';
            add.style = 'scale: 1.2';
            setTimeout(()=> {
                add.style = 'scale:1';
            }, [200]);
            setTimeout(()=> {
                document.getElementById(`${item.id}texte`).remove();
                add.style = 'animation: buttonLeft 1s forwards;';
                add.innerHTML = `
                <p>Répondre</p>
                <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
            `
            }, [800]);
        } else {
            add.insertAdjacentHTML("beforeBegin", `
                <textarea class="collapse-add-answer" placeholder="Répondre" id="${item.id}texte"></textarea>
            `);
            add.style = 'animation: buttonRight 1s forwards;';
            add.innerHTML = `
                <p>Envoyer</p>
                <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
            `
        }
    })

    button.addEventListener('click', () => {
        const content = document.getElementById(`${item.id}content`);	
        if (content.style.animation === '0.5s forwards show') {
            content.style = 'animation: hidden 0.5s forwards;';
        } else {
            content.style = 'animation: show 0.5s forwards;';
        }
        button.classList.toggle('alone');
    });
});