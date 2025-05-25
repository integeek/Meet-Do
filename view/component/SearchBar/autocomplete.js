document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.getElementById('searchBtn');
    const autocompleteContainer = document.getElementById('autocompleteContainer');
    const autocompleteInput = document.getElementById('autocompleteInput');
    const suggestionsContainer = document.getElementById('suggestions');

    searchBtn.addEventListener('click', () => {
        autocompleteContainer.style.display = 
            autocompleteContainer.style.display === 'none' ? 'block' : 'none';
    });

    autocompleteInput.addEventListener('input', async () => {
        const query = autocompleteInput.value;

        if (query.length < 3) {
            suggestionsContainer.innerHTML = '';
            return;
        }

        const response = await fetch(`https://api.locationiq.com/v1/autocomplete?key=pk.d1e3a3fe1d9a93351d306e093bc54eb2
&q=${encodeURIComponent(query)}&limit=5&format=json`);
        const data = await response.json();

        suggestionsContainer.innerHTML = '';

        data.forEach(location => {
            const li = document.createElement('li');
            li.textContent = location.display_name;
            li.addEventListener('click', () => {
                autocompleteInput.value = location.display_name;
                suggestionsContainer.innerHTML = '';
                // Tu peux ici stocker lat/lon si besoin
                console.log(location.lat, location.lon);
            });
            suggestionsContainer.appendChild(li);
        });
    });
});
