document.addEventListener('DOMContentLoaded', function() {
    let timer;
    const cityInput = document.getElementById('city');
    const cityResults = document.getElementById('city-results');
    const cityId = document.getElementById('city_id');

    cityInput.addEventListener('input', function() {
        const query = cityInput.value.trim();
        clearTimeout(timer);

        if (query.length < 2) {
            cityResults.classList.add('hidden');
            cityResults.innerHTML = '';
            return;
        }

        timer = setTimeout(() => {
            fetch(`/cities/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    cityResults.innerHTML = '';
                    if (!data.length) {
                        cityResults.classList.add('hidden');
                        return;
                    }
                    data.forEach(city => {
                        const li = document.createElement('li');
                        li.textContent = city.name;
                        li.dataset.id = city.id;
                        li.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                        cityResults.appendChild(li);
                    });
                    cityResults.classList.remove('hidden');
                });
        }, 300);
    });

    cityResults.addEventListener('click', function(e) {
        if (e.target.tagName === 'LI') {
            cityInput.value = e.target.textContent;
            cityId.value = e.target.dataset.id;
            cityResults.classList.add('hidden');
            cityResults.innerHTML = '';
        }
    });

    document.addEventListener('click', function(e) {
        if (!cityResults.contains(e.target) && e.target !== cityInput) {
            cityResults.classList.add('hidden');
            cityResults.innerHTML = '';
        }
    });
});
