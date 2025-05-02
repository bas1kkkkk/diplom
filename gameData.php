<?php

function getGameInfo($gameName) {
    $url = "https://www.cheapshark.com/api/1.0/games?title=" . urlencode($gameName) . "&limit=1";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (!empty($data)) {
        // Ищем точное совпадение названия
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


?>
