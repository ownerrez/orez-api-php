<?php

require __DIR__ . '/../vendor/autoload.php';

use OwnerRez\Api\Client;

require __DIR__ . '\test-credentials.php';

$ownerRez = new Client($test_username, $test_accessToken, $test_baseUri);

echo $ownerRez->properties()->search([ 'availabilityFrom' => '2020-01-01', 'availabilityTo' => '2020-01-08', 'limit' => 10, 'offset' => 0 ]);