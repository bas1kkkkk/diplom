document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('search-input');
    const button = document.getElementById('search-button');
    const form = document.querySelector('form');
    const list = document.getElementById('autocomplete-list');

    //Обработчик кнопки поиска
    button.addEventListener('click', function(event) {
        event.preventDefault();
        form.submit();
    });

    //Обработчик Enter в поле
    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // предотвращаем двойной submit
            form.submit();
        }
    });

    //Автозаполнение
    input.addEventListener('input', async function () {
        const query = this.value.trim();
        list.innerHTML = '';
        if (query.length < 2) return;

        try {
            const response = await fetch(`https://www.cheapshark.com/api/1.0/games?title=${encodeURIComponent(query)}&limit=5`);
            const results = await response.json();

            results.forEach(game => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = game.external;
                item.addEventListener('click', () => {
                    input.value = game.external;
                    list.innerHTML = '';
                });
                list.appendChild(item);
            });

            // Позиционируем список под input
            const rect = input.getBoundingClientRect();
            list.style.left = `${rect.left}px`;
            list.style.top = `${rect.bottom + window.scrollY}px`;
            list.style.width = `${rect.width}px`;

        } catch (err) {
            console.error('Ошибка автозаполнения:', err);
        }
    });

    // Закрываем список при клике вне input'а
    document.addEventListener('click', (e) => {
        if (e.target !== input) {
            list.innerHTML = '';
        }
    });
});
