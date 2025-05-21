const InputActivity = document.getElementById("InputActivity");
const AddActivityTheme = document.getElementById("AddActivityTheme");
const ActivitesThemes = document.getElementById("ActivitesThemes");
const InputForumTheme = document.getElementById("InputForumTheme");
const AddForumTheme = document.getElementById("AddForumTheme");
const ForumThemes = document.getElementById("ForumThemes");

const Refresh = () => {
    var request = new XMLHttpRequest();
    request.open("GET", `../../controller/Admin/ModifierTablesControlleur.php`, true);
    request.send();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const responseData = JSON.parse(this.responseText);
                data = responseData;
                console.log(data, "data");
                Themes();
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        } else if (this.readyState == 4) {
            console.error("Error: Unable to fetch data. Status:", this.status);
        }
    };
}

const AddThemeActivity = (theme) => {
    var request = new XMLHttpRequest();
    request.open("POST", `../../controller/Admin/ModifierTablesControlleur.php?type=activite`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const body = JSON.stringify({
        themes: theme
    });

    request.send(body);
}

const AddThemeForum = (theme) => {
    var request = new XMLHttpRequest();
    request.open("POST", `../../controller/Admin/ModifierTablesControlleur.php?type=forum`, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    const body = JSON.stringify({
        themes: theme
    });

    request.send(body);
}

const Themes = () => {
    ActivitesThemes.innerHTML = "";
    ForumThemes.innerHTML = "";

    data.Forum.forEach((element) => {
        ForumThemes.innerHTML += `<div class="theme-box">${element.themes}</div>`;
    });
    data.Activite.forEach((element) => {
        ActivitesThemes.innerHTML += `<div class="theme-box">${element.themes}</div>`;
    });
}

AddActivityTheme.addEventListener("click", () => {
    let theme = InputActivity.value;
    AddThemeActivity(theme);
    setTimeout(() => {
        InputActivity.value = "";
        Refresh();
    }, 500);
});

AddForumTheme.addEventListener("click", () => {
    let theme = InputForumTheme.value;
    AddThemeForum(theme);
    setTimeout(() => {
        InputForumTheme.value = "";
        Refresh();
    }, 500);
});

Refresh();