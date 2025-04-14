const data = [
    {
        id : 1,
        name : "Jean Bernard",
        messages : [
            {
                id : 1,
                sender : "Jean Bernard",
                date : "2023-10-01",
                time : "12:00",
                content : "Bonjour, comment ça va ?",
                attachment : false
            },
            {
                id : 2,
                sender : "Moi",
                date : "2023-10-01",
                time : "12:05",
                content : "Salut, ça va bien et toi ?",
                attachment : false
            },
            {
                id : 3,
                sender : "Jean Bernard",
                date : "2023-10-01",
                time : "12:10",
                content : "Je vais bien aussi, merci !",
                attachment : false
            },
            {
                id : 4,
                sender : "Jean Bernard",
                date : "2023-10-01",
                time : "12:15",
                content : "Tu veux qu'on se voit ce soir ?",
                attachment : false
            },
            {
                id : 5,
                sender : "Moi",
                date : "2023-10-01",
                time : "12:20",
                content : "Oui, avec plaisir !",
                attachment : false
            },
            {
                id : 6,
                sender : "Jean Bernard",
                date : "2023-10-01",
                time : "12:25",
                content : "Super ! À quelle heure ?",
                attachment : false
            },
            {
                id : 7,
                sender : "Moi",
                date : "2023-10-01",
                time : "12:30",
                content : "Vers 19h ?",
                attachment : false
            }
        ]
    },
    {
        id : 2,
        name : "Marie Dupont",
        messages : [
            {
                id : 1,
                sender : "Marie Dupont",
                date : "2023-10-01",
                time : "13:00",
                content : "Salut, tu es dispo pour le projet ?",
                attachment : false
            },
            {
                id : 2,
                sender : "Moi",
                date : "2023-10-01",
                time : "13:05",
                content : "Oui, je suis là !",
                attachment : false
            },
            {
                id : 3,
                sender : "Marie Dupont",
                date : "2023-10-01",
                time : "13:10",
                content : "Super, on peut se voir à la bibliothèque ?",
                attachment : false
            },
            {
                id : 4,
                sender : "Moi",
                date : "2023-10-01",
                time : "13:15",
                content : "Oui, bonne idée ! À tout de suite.",
                attachment : false
            }
        ]
    },
    {
        id: 3,
        name: 'Paul Martin',
        messages: [
            {
                id: 1,
                sender: 'Paul Martin',
                date: '2023-10-02',
                time: '14:00',
                content: 'lien',
                attachment: true
            },
            {
                id: 2,
                sender: 'Moi',
                date: '2023-10-02',
                time: '14:05',
                content: 'Oui, merci ! Je vais le lire.',
                attachment: false
            },
            {
                id: 3,
                sender: 'Paul Martin',
                date: '2023-10-02',
                time: '14:10',
                content: 'Parfait, dis-moi ce que tu en penses.',
                attachment: false
            }
        ]
    },
    {
        id: 4,
        name: 'Sophie Durand',
        messages: [
            {
                id: 1,
                sender: 'Sophie Durand',
                date: '2023-10-03',
                time: '15:00',
                content: 'Salut, tu as reçu le document ?',
                attachment: true
            },
            {
                id: 2,
                sender: 'Moi',
                date: '2023-10-03',
                time: '15:05',
                content: 'Oui, je l\'ai bien reçu. Merci !',
                attachment: false
            },
            {
                id: 3,
                sender: 'Sophie Durand',
                date: '2023-10-03',
                time: '15:10',
                content: 'Super, on peut en discuter demain ?',
                attachment: false
            }
        ]
    }
]

const userFields = document.getElementById('fieldset');
const attachmentInput = document.getElementById('attachment');
const messageContent = document.getElementsByClassName('message-content')[0];
const sendMessage = document.getElementById('send-message');
const sendText = document.getElementById('message');
let file = null;
let talkID = 0;

const RefreshMessage = (id) => {
    data.forEach(user => {
        if (user.id == id) {
            messageContent.innerHTML = `
                <div class="grow"></div>
            `;
            messageContent.innerHTML += user.messages.map(message => {
                return `
                    <div class="message-message ${message.sender === user.name ? "" : "message-message-own"}">
                        <p class="message-date">${message.date + " " + message.time}</p>
                        <div class="message-text">
                            ${message.attachment ? `<img src="../assets/img/macaron1.jpeg" alt="attachment" class="attachment" />` : `<p>${message.content}</p>`}
                            
                        </div>
                    </div>
                `;
            }).join('');
        }
    });
    messageContent.scrollTop = messageContent.scrollHeight - messageContent.clientHeight;
};

talkID = data[0].id;
RefreshMessage(talkID);


userFields.innerHTML = data.map((user, index) => {
    return `
                <div class="user">
                    <input type="radio" id="${user.name}" name="user" value="${user.id}" ${index === 0 ? "checked" : ""} />
                    <label for="${user.name}">
                        <div class="select-user">
                            <img src="../assets/img/profil.png" alt="avatar" class="avatar" />
                            <p class="user-name">${user.name}</p>
                            <div class="grow"></div>
                            <img src="../assets/img/more.png" alt="more" class="more" />
                        </div>
                        <p class="user-message">${user.messages[user.messages.length-1].content}</p>
                    </label>
                </div>
    `;
}).join('');

userFields.addEventListener('change', (event) => {
    console.log(messageContent)
    messageContent.style = "animation: out 0.5s forwards;";
    setTimeout(() => {
        RefreshMessage(event.target.value);
        talkID = event.target.value;
        messageContent.style = "animation: in 0.5s forwards;";
        setTimeout(() => {
            messageContent.style = "animation: none;";
        }, 500);
    }, 500);

})

attachmentInput.addEventListener('change', () => {
    file = event.target;
    if (file.files.length > 0) {
        const fileName = file.files[0].name;
        const attachmentLabel = document.getElementById('send-attachment');
        attachmentLabel.innerHTML = `<p>${fileName}</p><img src="../assets/img/croix.png" alt="croix" class="message-input-croix">`;
        const croix = document.querySelector('.message-input-croix');
        croix.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default behavior
            file = null;
            attachmentInput.value = null;
            attachmentLabel.innerHTML = `<img src="../assets/img/icons/attachFile.svg" alt="file">`;
        });
    }
});

sendMessage.addEventListener('click', () => {
    if (sendText.value !== "" || file?.files.length > 0) {
        const message = {
            id: data[data.length - 1].messages.length + 1,
            sender: "Moi",
            date: new Date().toLocaleDateString(),
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            content: file?.files.length > 0 ? file.files[0].name : sendText.value,
            attachment: file?.files.length > 0
        };
        const attachmentLabel = document.getElementById('send-attachment');
        if (sendText.value !== "") {
            sendText.style = "animation: send 1s forwards;"
        } else {
            attachmentLabel.style = "animation: send 1s forwards;"
        }  
        setTimeout(() => {
            sendText.value = "";
        }, 1000);
        file = null;
        attachmentInput.value = null;
        attachmentLabel.innerHTML = `<img src="../assets/img/icons/attachFile.svg" alt="file">`;
        data.forEach(user => {
            if (user.id == talkID) {
                user.messages.push(message);
            }
        });
        RefreshMessage(talkID);
    }
});

window.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && (sendText.value !== "" || file?.files.length > 0)) {
        sendMessage.click();
    }
});
