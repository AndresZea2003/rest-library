<?php

require_once __DIR__ . '/../bootstrap.php';

// Query Information
$internalReference = 'YOUR_INTERNAL_REFERENCE_HERE';

$response= $this->placetopay->query($internalReference);

if ($response->isSuccessful()) {
    // $response->toArray()['response'];
} else {
    // There was some error so check the message
    // $response->status()->message();
}
