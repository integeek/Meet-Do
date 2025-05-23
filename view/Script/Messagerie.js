const userFields = document.getElementById('fieldset');
const attachmentInput = document.getElementById('attachment');
const messageContent = document.getElementsByClassName('message-content')[0];
const sendMessage = document.getElementById('send-message');
const sendText = document.getElementById('message');
let file = null;
let talkID = 0;

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Messagerie/MessagerieControlleur.php?action=users`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                // Parse the JSON response
                const responseData = JSON.parse(this.responseText);
                Sidedata = responseData;
                if (responseData.message === 'La table est vide.') {
                    document.getElementsByTagName('main')[0].innerHTML = `
                    <h1>Messagerie</h1>
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; margin-top: 5rem;">
                        <img src="../../view/assets/img/icons/warning-icon.svg" alt="warning-icon" id="warning-icon" />
                        <h2 id="warning-text">Aucun message trouvé.</h2>
                        <p id="warning-subtext">Vous n'avez pas encore de messages.</p>
                    </div>
                    `;
                } else {
                    renderSideBar();
                }


            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

Refresh();

const Refresh2 = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Messagerie/MessagerieControlleur.php?id=${talkID}&action=messages`, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                // Parse the JSON response
                const responseData = JSON.parse(this.responseText);
                MessageData = responseData;
                RefreshMessage();

            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const sendMessageFunction = (message) => {
    var request = new XMLHttpRequest();
    request.open("POST", "./../../controller/Messagerie/MessagerieControlleur.php?action=send", true);

    const formData = new FormData();
    formData.append('idRecepteur', message.idRecepteur);
    formData.append('content', message.content);
    if (message.attachment) {
        formData.append('file', file.files[0]);
    }

    request.send(formData);

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
}

const RefreshMessage = () => {
    messageContent.innerHTML = `
                <div class="grow"></div>
            `;
    messageContent.innerHTML += MessageData.map(message => {
        return `
            <div class="message-message ${talkID == message.senderId ? "" : "message-message-own"}">
            <p class="message-date">${message.date + " " + new Date(new Date("1970-01-01T" + message.time + "Z").getTime() + 1 * 60 * 60 * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}</p>
            <div class="message-text">
            ${message.attachement ? `<img src="../../${message.content}" alt="attachment" class="attachment" />` : `<p>${message.content}</p>`}
            
            </div>
            </div>
            `;
    }).join('');
    messageContent.scrollTop = messageContent.scrollHeight - messageContent.clientHeight;
};

const renderSideBar = () => {
    userFields.innerHTML = Sidedata.map((user) => {
        return `
                <div class="user">
                    <input type="radio" id="${user.name}" name="user" value="${user.idClient}" />
                    <label for="${user.name}">
                        <div class="select-user">
                            <img src="../assets/img/profil.png" alt="avatar" class="avatar" />
                            <p class="user-name">${user.name}</p>
                            <div class="grow"></div>
                            <img src="../assets/img/more.png" alt="more" class="more" />
                        </div>
                        <p class="user-message">${user.has_attachement ? "Image" : user.last_message}</p>
                    </label>
                </div>
    `;
    }).join('');

    userFields.addEventListener('change', (event) => {
        messageContent.style = "animation: out 0.5s forwards;";
        setTimeout(() => {
            //RefreshMessage(event.target.value);
            talkID = event.target.value;
            messageContent.style = "animation: in 0.5s forwards;";
            Refresh2();
            setTimeout(() => {
                messageContent.style = "animation: none;";
            }, 500);
            document.querySelector('.message-input').classList.remove('invisible');
        }, 500);
    })
}

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
        // const message = {
        //     id: data[data.length - 1].messages.length + 1,
        //     sender: "Moi",
        //     date: new Date().toLocaleDateString(),
        //     time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        //     content: file?.files.length > 0 ? file.files[0].name : sendText.value,
        //     attachment: file?.files.length > 0
        // };
        sendMessageFunction({ content: file?.files.length > 0 ? file.files[0].name : sendText.value, attachment: file?.files.length > 0, idRecepteur: talkID });
        const attachmentLabel = document.getElementById('send-attachment');
        if (sendText.value !== "") {
            sendText.style = "animation: send 1s forwards;"
        } else {
            attachmentLabel.style = "animation: send 1s forwards;"
        }
        setTimeout(() => {
            sendText.value = "";
            file = null;
            attachmentInput.value = null;
            attachmentLabel.innerHTML = `<img src="../assets/img/icons/attachFile.svg" alt="file">`;
        }, 1000);

        setTimeout(() => {
            sendText.style = "animation: none;"
            attachmentLabel.style = "animation: none;"
            Refresh2();
        }, 1000);
    }
});

window.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && (sendText.value !== "" || file?.files.length > 0)) {
        sendMessage.click();
    }
});
