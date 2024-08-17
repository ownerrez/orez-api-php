<?php

require __DIR__ . '/../vendor/autoload.php';

use OwnerRez\Api\Client;

require __DIR__ . '/test-credentials.php';

$ownerRez = new Client($test_username, $test_accessToken, $test_baseUri);

$response = $ownerRez->properties()->search([ 'availabilityFrom' => '2020-01-01', 'availabilityTo' => '2020-01-08', 'limit' => 10, 'offset' => 0 ]);

echo json_encode($response, JSON_PRETTY_PRINT);

$response = $ownerRez->externalSites()->register('https://wordpress.dev.cc', time());

echo json_encode($response, JSON_PRETTY_PRINT);
