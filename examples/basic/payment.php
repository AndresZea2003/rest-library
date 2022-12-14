<?php

require_once __DIR__ . '/../bootstrap.php';

// Creating a random reference for the test
$reference = 'TEST_' . time();

// Process Information
$request = [
    'payment' => [
        'reference' => $reference,
        'description' => 'Payment Rest test',
        'amount' => [
            'currency' => 'USD',
            'total' => 100,
        ],
        "allowPartial" => false
    ],
    "instrument" => [
        "card" => [
            "number" => "36545400000008",
            "expiration" => "12/20",
            "cvv" => "123",
            "installments" => 2
        ]
    ],
    'ipAddress' => '127.0.0.1',
    'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
];

$response = $placetopay->process($request);

if ($response->isSuccessful()) {
    // $response->toArray()['response'];
} else {
    // There was some error so check the message
    // $response->status()->message();
}
