<?php
header('Content-Type: application/json');
require_once 'currencyConverter.php';

$to = isset($_GET['to']) ? strtoupper($_GET['to']) : 'UAH';
$rate = getExchangeRate('USD', $to);

if ($rate) {
    echo json_encode(['rate' => $rate]);
} else {
    echo json_encode(['error' => 'Conversion rate not available']);
}
