function ajouterTheme(inputId, containerId) {
    let inputElement = document.getElementById(inputId);
    let theme = inputElement.value.trim();
    if (theme === "") return;

    let containerElement = document.getElementById(containerId);

    let tag = document.createElement("span");
    tag.classList.add("tag");
    tag.innerHTML = theme + ' <button onclick="this.parentElement.remove()">✕</button>';

    containerElement.appendChild(tag);
    inputElement.value = ""; 
}
