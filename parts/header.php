<?php
$searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PlaySmart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <h1 class="site-title">Економ на іграх — грай більше!</h1>

        <div class="header-buttons">
            <form method="GET" action="index.php">
                <input type="text" name="search" id="search-input" placeholder="Введiть назву гри" value="<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off">
                <button type="submit" id="search-button" class="search-button" aria-label="Поиск">
                    🔍
            </button>
            </form>
            <div id="autocomplete-list" class="autocomplete-items"></div>
            <button id="theme-toggle">Змiнити тему</button>
            <select id="currency-selector">
                <option value="USD" selected>USD ($)</option>
                <option value="UAH">UAH (₴)</option>
                <option value="EUR">EUR (€)</option>
            </select>
            <button id="button4">Кнопка 4</button>
        </div>
    </div>
</header>


