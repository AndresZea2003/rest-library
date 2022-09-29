<?php

require_once __DIR__ . '/../bootstrap.php';

$internalReference = 'YOUR_INTERNAL_REFERENCE_HERE';
$authorization = 'YOUR_AUTHORIZATION_NUMBER_HERE';

// Reverse Information
$request = [
    'internalReference' => $internalReference,
    'authorization' => $authorization,
    'action' => 'reverse'
];

$response = $this->placetopay->reverse($request);

if ($response->isSuccessful()) {
    // $response->toArray()['response'];
} else {
    // There was some error so check the message
    // $response->status()->message();
}
