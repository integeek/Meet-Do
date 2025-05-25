console.log('SearchBar script loaded');

document.addEventListener('DOMContentLoaded', () => {
    const positionBtn = document.getElementById('position-btn');
    const popup = document.getElementById('position-popup');

    // Ouvrir la popup
    positionBtn.addEventListener('click', () => {
        popup.classList.toggle('hidden');
    });

    // Bouton "Non"
    document.getElementById('cancel-location').addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    // Bouton "Oui"
    document.getElementById('confirm-location').addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    const adresseInput = document.getElementById('adresse');
    const suggestionsContainer = document.getElementById('suggestions');

    if (adresseInput && suggestionsContainer) {
        adresseInput.addEventListener('input', async () => {
            const query = adresseInput.value.trim();

            if (query.length < 3) {
                suggestionsContainer.innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`https://api.locationiq.com/v1/autocomplete?key=pk.d1e3a3fe1d9a93351d306e093bc54eb2&q=${encodeURIComponent(query)}&limit=5&format=json`);
                const data = await response.json();

                suggestionsContainer.innerHTML = '';

                data.forEach(location => {
                    const li = document.createElement('li');
                    li.textContent = location.display_name;
                    li.addEventListener('click', () => {
                        adresseInput.value = location.display_name;
                        suggestionsContainer.innerHTML = '';
                    });
                    suggestionsContainer.appendChild(li);
                });
            } catch (error) {
                console.error('Erreur lors de la récupération des suggestions :', error);
                suggestionsContainer.innerHTML = '<li>Erreur de recherche</li>';
            }
        });
    } else {
        console.warn('Champ d\'adresse ou suggestions non trouvés dans le DOM');
    }
});
