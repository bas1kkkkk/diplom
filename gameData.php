<?php

// 🔁 Універсальна функція кешування запиту
function getCachedData($cacheKey, $url, $ttl = 86400) {
    $cacheDir = __DIR__ . '/cache';

    // 📁 Створюємо папку cache, якщо її не існує
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    $cacheFile = $cacheDir . '/' . md5($cacheKey) . '.json';

    // 🧾 Якщо файл існує і ще не застарів — повертаємо з кешу
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $ttl)) {
        return json_decode(file_get_contents($cacheFile), true);
    }

    // 🌐 Отримуємо дані з API
    $response = @file_get_contents($url);
    if ($response === false) {
        return null;
    }

    // 💾 Зберігаємо у файл кешу
    file_put_contents($cacheFile, $response);
    return json_decode($response, true);
}

// 🎮 Отримати загальну інформацію про гру з CheapShark
function getGameInfo($gameName) {
    $url = "https://www.cheapshark.com/api/1.0/games?title=" . urlencode($gameName) . "&limit=1";
    $data = getCachedData('cheapshark_game_' . $gameName, $url);

    if (!empty($data)) {
        foreach ($data as $game) {
            if (strcasecmp($game['external'], $gameName) == 0) {
                return $game;
            }
        }
        return $data[0];
    }

    return null;
}

// 💸 Отримати список знижок для гри за її ID
function getGameDeals($gameID) {
    $url = "https://www.cheapshark.com/api/1.0/games?id=" . urlencode($gameID);
    $data = getCachedData('cheapshark_deals_' . $gameID, $url);

    if (!empty($data) && isset($data['deals'])) {
        return $data['deals'];
    }

    return null;
}

// 🛍 Отримати список магазинів для співставлення ID => Назва
function getStoresMap() {
    $url = 'https://www.cheapshark.com/api/1.0/stores';
    $stores = getCachedData('cheapshark_stores', $url);

    $storeMap = [];
    foreach ($stores as $store) {
        $storeMap[$store['storeID']] = $store['storeName'];
    }

    return $storeMap;
}

// 📊 Отримати детальну інформацію про гру з RAWG API
function getRawgInfo($gameName) {
    $apiKey = '3c73e733b66c4c38b0c30137de245589';

    // 🔍 Пошук гри за назвою
    $searchUrl = "https://api.rawg.io/api/games?search=" . urlencode($gameName) . "&key=$apiKey&page_size=1";
    $searchData = getCachedData('rawg_search_' . $gameName, $searchUrl);

    if (!empty($searchData['results'][0])) {
        $game = $searchData['results'][0];
        $slug = $game['slug'];

        // Запрос подробной информации о игре
        $detailsUrl = "https://api.rawg.io/api/games/$slug?key=$apiKey";
        $details = getCachedData('rawg_details_' . $slug, $detailsUrl);

        // Запрос скриншотов игры (5 скриншотов)
        $screenshotsUrl = "https://api.rawg.io/api/games/$slug/screenshots?key=$apiKey&page_size=5";
        $screenshotsData = getCachedData('rawg_screenshots_' . $slug, $screenshotsUrl);

        // Собираем все нужные данные
        return [
            'name' => $details['name'] ?? '',
            'image' => $details['background_image'] ?? '',
            'genres' => $details['genres'] ?? [],
            'tags' => $details['tags'] ?? [],
            'rating' => $details['rating'] ?? '',
            'playtime' => $details['playtime'] ?? '',
            'description' => $details['description'] ?? '',
            'metacritic' => $details['metacritic'] ?? '',
            'released' => $details['released'] ?? '',
            'metacritic_url' => $details['metacritic_url'] ?? '',
            'platforms' => $details['platforms'] ?? [],
            'screenshots' => $screenshotsData['results'] ?? [],  // Скриншоты
        ];
    }

    return null;
}


?>
