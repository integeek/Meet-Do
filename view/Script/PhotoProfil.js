// Affichage dynamique de la photo de profil
export function chargerPhotoProfil() {
  fetch('../../controller/Compte/PhotoController.php', { method: 'GET' })
    .then(response => response.json())
    .then(data => {
      const img = document.getElementById('profile-icon');
      if (img) {
        if (data.photo && data.photo !== "null" && data.photo !== "") {
          img.src = data.photo;
        } else {
          img.src = "../assets/img/icons/profile-icon.svg";
        }
      }
    })
    .catch(() => {
      const img = document.getElementById('profile-icon');
      if (img) img.src = "../assets/img/icons/profile-icon.svg";
    });
}

// Ouvre le pop-up à l'ouverture du bouton
export function setupPhotoProfilPopup() {
  const bouton = document.getElementById("boutonContainer");
  if (bouton) {
    bouton.onclick = function () {
      openPopUp('edit-photo-popup');
    };
  }

  // Upload automatique dès qu'un fichier est choisi
  const input = document.getElementById("input-pdp");
  if (input) {
    input.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;
      const formData = new FormData();
      formData.append("photo", file);

      fetch("../../controller/Compte/PhotoController.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.text())
        .then(() => {
          closePopUp('edit-photo-popup');
          window.location.reload();
        })
        .catch(() => {
          alert("Erreur lors de l'upload de la photo.");
          closePopUp('edit-photo-popup');
          window.location.reload();
        });
    });
  }
}