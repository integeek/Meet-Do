// Script réutilisable pour afficher une popup d'erreur rouge pendant 10 secondes

// Ajoute la popup à la page si elle n'existe pas déjà
(function() {
    if (!document.getElementById('errorPopup')) {
        const popup = document.createElement('div');
        popup.id = 'errorPopup';
        popup.style.display = 'none';
        popup.style.position = 'fixed';
        popup.style.top = '30px';
        popup.style.left = '50%';
        popup.style.transform = 'translateX(-50%)';
        popup.style.background = '#e74c3c';
        popup.style.color = '#fff';
        popup.style.padding = '20px 40px';
        popup.style.borderRadius = '8px';
        popup.style.zIndex = '10000';
        popup.style.fontSize = '1.2rem';
        popup.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
        document.body.appendChild(popup);
    }
})();

window.showErrorPopup = function(message) {
    const popup = document.getElementById('errorPopup');
    popup.textContent = message;
    popup.style.display = 'block';
    clearTimeout(window._errorPopupTimeout);
    window._errorPopupTimeout = setTimeout(() => {
        popup.style.display = 'none';
    }, 10000);
};