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

  } else {
    return `
          <button class="buttonCo" type="submit">
              ${texte}
          </button>
      `;
  }
}
