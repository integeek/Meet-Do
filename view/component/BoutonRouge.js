function BoutonRouge(texte) {
  if (texte === "Annuler ma réservation") {
    return `
        <button onclick="openPopUp('cancel-popup')" class="buttonRo" type="submit">
            ${texte}
        </button>
    `;
  } else {
    return `
        <button type="button" class="buttonRo" >${texte}</button>
`;
  }
}
