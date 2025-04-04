function BoutonBleu(texte, url) {
  return `
        <button class="buttonCo" type="button" onclick="window.location.href='${url}'">
            ${texte}
        </button>
    `;
}
