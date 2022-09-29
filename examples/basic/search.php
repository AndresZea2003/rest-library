<?php

require_once __DIR__ . '/../bootstrap.php';

// Enter the reference of the transaction you are looking for
$reference = 'SEARCHED_REFERENCE';

// Search Information
$request = [
    "reference" => $reference,
    "amount" => [
        "currency" => "COP",
        "total" => "1000",
    ],
];

$response = $this->placetopay->search($request);

if ($response->isSuccessful()) {
    // $response->toArray()['response'];
} else {
    // There was some error so check the message
    // $response->status()->message();
}
