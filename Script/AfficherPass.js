// Sélectionne tous les boutons d'affichage de mot de passe
document.querySelectorAll(".togglePassword").forEach((toggle) => {
    toggle.addEventListener("click", function() {
        // Trouve l'input associé
        let passwordField = this.previousElementSibling;

        // Alterne entre "password" et "text"
        if (passwordField.type === "password") {
            passwordField.type = "text";
            this.src = "../assets/img/ferme.png"; 
        } else {
            passwordField.type = "password";
            this.src = "../assets/img/ouvert.png"; 
        }
    });
});
