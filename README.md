# PlacetoPay Api Rest PHP library

With this code you will be able to quickly connect with the PlacetoPay Rest service.

In order to see more comprehensive examples of how it works, please refer to the examples and
the [documentation](https://docs-gateway.placetopay.com/)

## Installation

Using composer from your project

```
composer require zea/rest-library
```

Or If you just want to run the examples contained in this project run "composer install" to load the vendor autoload

## Usage

Create an object with the configuration required for that instance

```php 
$placetopay = new Zea\RestLibrary\PlacetoPay([
    'login' => 'YOUR_LOGIN', // Provided by PlacetoPay
    'tranKey' => 'YOUR_TRANSACTIONAL_KEY', // Provided by PlacetoPay
    'baseUrl' => 'https://THE_BASE_URL_TO_POINT_AT',
    'timeout' => 10, // (optional) 15 by default
]);
```

### Creating a new payment request to get a Payment Response

Simply provide the necessary payment information and you will get a Process Response if successful, for this example,
are using the MINIMUM INFORMATION that must be provided, to see the complete structure, consult the documentation or the
example in [examples/basic/payment.php](examples/basic/payment.php)

```
$reference = 'COULD_BE_THE_PAYMENT_ORDER_ID";
$request = [
    'payment' => [
        'reference' => $reference,
        'description' => 'Testing payment',
        'amount' => [
            'currency' => 'USD',
            'total' => 120,
        ],
    ],
    'instrument' => [
        'card' => [
            'number' => '36545400000008',
            'expiration' => '12/20',
            'cvv' => '123',
            'installments' => 2
        ]
    ],
    'ipAddress' => '127.0.0.1',
    'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
];

$response = $placetopay->process($request);
if ($response->isSuccessful()) {
    // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
    // Redirect the client to the processUrl or display it on the JS extension
    $response->processUrl();
} else {
    // There was some error so check the message and log it
    $response->status()->message();
}
```
