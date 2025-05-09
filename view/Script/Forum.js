const themes = [
    "Themes",
    "Compte",
    "Réservation",
    "Règlement",
    "Bug"
];

const newQuestion = document.querySelector('#new-question-button');
const buttonSend = document.querySelector('.collapse-add-button');
const container = document.querySelector('.collapse-container');
const search = document.querySelector('.search');
let theme = "";
let searchValue = "";
let response = "";
let userId = -1;
let userName = "";

const GetUserId = () => {
    var request = new XMLHttpRequest();
    request.open("GET", "./../../controller/Navbar/Navbar.php", true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                console.log(responseData);
                if (responseData.success) {
                    userId = responseData.user.id;
                    userName = responseData.user.prenom + " " + responseData.user.nom;
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
};

GetUserId();

const Post = (idForum) => {
    var request = new XMLHttpRequest();
    request.open("POST", "./../../controller/Forum/AddResponse.php", true);
    request.setRequestHeader("Content-Type", "application/json");

    const body = JSON.stringify({
        idMessage: idForum,
        idUser: userId,
        message: message
    });
    
    request.send(body);

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                console.log(responseData);
                if (responseData.success) {
                    console.log("Message ajouté avec succès !");
                } else {
                    console.error("Erreur :", responseData.message);
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
    setTimeout(() => {
        const content = document.getElementById(`${idForum}content`);
        const newElement = document.createElement('div');
        newElement.className = 'collapse-content-answer';
        newElement.innerHTML = `
            <img src="../assets/img/return.png" alt="return icon" class="collapse-return" />
            <div class="collapse-header">
            <img src="../assets/img/profil.png" alt="profil icon" class="collapse-profil" />
            <p>${userName}</p>
            <div class="grow"></div>
            <p>${new Date().toLocaleString()}</p>
            <img src="../assets/img/more.png" alt="more icon" class="collapse-more" />
            </div>
            <div></div>
            <div class="collapse-question">${response}</div>
        `;
        const addButton = content.querySelector('.collapse-add');
        content.insertBefore(newElement, addButton);
    }, 500);
}

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Forum/Forum.php?selectBy=${theme}&search=${searchValue}`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                // Parse the JSON response
                const responseData = JSON.parse(this.responseText);
                console.log(responseData); // Log the parsed data

                // Replace the existing data with the new data
                data = responseData;

                // Re-render the container with the new data
                renderForumContent();
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

search?.addEventListener('input', (e) => {
    searchValue = e.target.value;
    Refresh();
});

newQuestion.addEventListener('click', () => {
    console.log("Ajout d'une nouvelle question");
});

const renderForumContent = () => {
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
                        ${item.answer.length > 0 ?
                `    
                            <div class="grow"></div>
                            <p>${item.answer.length}</p>
                            <img src="../assets/img/icons/message-square.svg" alt="message" class="message" />
                        `
                : ""
            }
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
            ${userId !== -1 ? `
                <div class="collapse-add">
                    <button type="button" class="collapse-add-button" id="${item.id}add">
                        <p>Répondre</p>
                        <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
                    </button>
                </div>
            ` : ""}
            </div>
        </div>
    `;
    }).join('');
    attachEventListeners();
}

const attachEventListeners = () => {
    data.forEach((item) => {
        const button = document.getElementById(`${item.id}btn`);

        if (userId !== -1) {
            const more = document.getElementById(`${item.id}more`);
            const add = document.getElementById(`${item.id}add`);

            add.addEventListener('click', () => {
                if (document.getElementById(`${item.id}texte`)) {
                    Post(item.id);
                    document.getElementById(`${item.id}texte`).style = 'animation: send 1s forwards;';
                    add.style = 'scale: 1.2';
                    setTimeout(() => {
                        add.style = 'scale:1';
                    }, [200]);
                    setTimeout(() => {
                        document.getElementById(`${item.id}texte`).remove();
                        add.style = 'animation: buttonLeft 1s forwards;';
                        add.innerHTML = `
                <p>Répondre</p>
                <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
            `
                    }, [800]);
                } else {
                    add.insertAdjacentHTML("beforeBegin",
                        `
                    <textarea class="collapse-add-answer" placeholder="Répondre" id="${item.id}texte"></textarea>
                `);
                    add.style = 'animation: buttonRight 1s forwards;';
                    add.innerHTML = `
                    <p>Envoyer</p>
                    <img src="../assets/img/message.png" alt="message icon" id="message-icon" />
                `;
                    document.getElementById(`${item.id}texte`).addEventListener('input', (e) => {
                        response = e.target.value;
                    });
                }
            })
        }

        button.addEventListener('click', () => {
            const content = document.getElementById(`${item.id}content`);
            if (content.style.animation === '0.5s ease 0s 1 normal forwards running show') {
                content.style = 'animation: hidden 0.5s forwards;';
            } else {
                content.style = 'animation: show 0.5s forwards;';
            }
            button.classList.toggle('alone');
        });
    });
}