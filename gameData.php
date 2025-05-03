<?php

function getGameInfo($gameName) {
    $url = "https://www.cheapshark.com/api/1.0/games?title=" . urlencode($gameName) . "&limit=1";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

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

function getGameDeals($gameID) {
    $url = "https://www.cheapshark.com/api/1.0/games?id=" . urlencode($gameID);
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (!empty($data) && isset($data['deals'])) {
        return $data['deals'];
    }

    return null;
}

function getStoresMap() {
    $json = file_get_contents('https://www.cheapshark.com/api/1.0/stores');
    $stores = json_decode($json, true);

    $storeMap = [];
    foreach ($stores as $store) {
        $storeMap[$store['storeID']] = $store['storeName'];
    }

    return $storeMap;
}


function getRawgInfo($gameName) {
    $apiKey = '3c73e733b66c4c38b0c30137de245589';

    $searchUrl = "https://api.rawg.io/api/games?search=" . urlencode($gameName) . "&key=$apiKey&page_size=1";
    $searchResponse = file_get_contents($searchUrl);
    $searchData = json_decode($searchResponse, true);

    if (!empty($searchData['results'][0])) {
        $game = $searchData['results'][0];
        $slug = $game['slug'];
 
        $detailsUrl = "https://api.rawg.io/api/games/$slug?key=$apiKey";
        $detailsResponse = file_get_contents($detailsUrl);
        $details = json_decode($detailsResponse, true);

        return [
            'name' => $details['name'] ?? '',
            'image' => $details['background_image'] ?? '',
            'genres' => $details['genres'] ?? [],
            'tags' => $details['tags'] ?? [],
            'rating' => $details['rating'] ?? '',
            'platforms' => $details['platforms'] ?? [],
            'screenshots' => $details['short_screenshots'] ?? [], // добавляем галерею скриншотов
        ];
    }

    return null;
}


?>
