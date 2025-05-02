<?php
function getExchangeRate($from, $to) {
    $apiKey = "0a53a8c63b3e85ffcc6385d1";
    $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/" . strtoupper($from);

    $response = @file_get_contents($url);
    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);

    if (isset($data['conversion_rates'][strtoupper($to)])) {
        return $data['conversion_rates'][strtoupper($to)];
    }

    return null;
}
?>
