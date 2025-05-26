function BoutonBleu(texte) {
  //prettier-ignore
  if (texte === "Voir l\'activité") {
    return `
          <button onclick="window.location.href='../../view/Page/Activite.php?id=window.activite.idActivite'" class="buttonCo" type="submit">
              ${texte}
          </button>
      `;

  }  else if (texte === "Modifier ma réservation") {
      return `
          <button onclick="openPopUp('edit-lastname-popup')" class="buttonCo" type="submit">
              ${texte}
          </button>
      `;
   } else if (texte === "Modifier mon activité") {
      return `
          <button onclick="openPopUp('edit-activity')" class="buttonCo" type="submit">
              ${texte}
          </button>
      `;

   } else if (texte === "Créer une activité") {
      return `
          <a href="../../view/Page/CreerActivite.php">
          <button class="buttonCo" type="submit">
              ${texte}
          </button>
          </a>
      `;
  } else if (texte === "Voir les activités disponibles") {
      return `
          <a href="../../view/Page/accueil.php">
          <button class="buttonCo" type="submit">
              ${texte}
          </button>
          </a>
      `;
  } else {
    return `
          <button class="buttonCo" type="submit">
              ${texte}
          </button>
      `;
  }
}
