const themeToggleButton = document.getElementById('theme-toggle');
const body = document.body;


const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    body.classList.add(savedTheme); 
}

// Обработчик для переключения темы
themeToggleButton.addEventListener('click', () => {
    // Переключаем класс для body
    if (body.classList.contains('dark-theme')) {
        body.classList.remove('dark-theme');
        body.classList.add('light-theme');
        localStorage.setItem('theme', 'light-theme'); 
    } else {
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');
        localStorage.setItem('theme', 'dark-theme');
    }
});
