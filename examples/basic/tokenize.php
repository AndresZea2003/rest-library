<?php

require_once __DIR__ . '/../bootstrap.php';

$card = 'YOUR_CARD_NUMBER_HERE';

// Tokenize Information
$request = [
    "payer" => [
        "name" => "Andres",
        "surname" => "Zea",
        "email" => "Zeatest@gmail.com"
    ],
    "instrument" => [
        "card" => [
            "number" => $card,
            "expiration" => "12/18",
            "cvv" => "123",
            "installments" => 3
        ]
    ],
    'ipAddress' => '127.0.0.1',
    'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
];

$response = $this->placetopay->tokenize($request);

if ($response->isSuccessful()) {
    // $response->toArray()['response'];
} else {
    // There was some error so check the message
    // $response->status()->message();
}
