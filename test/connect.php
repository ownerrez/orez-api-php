<?php

require __DIR__ . '/../vendor/autoload.php';

use OwnerRez\Api\Client;

require __DIR__ . '\test-credentials.php';

$ownerRez = new Client($test_username, $test_accessToken, $test_baseUri);

echo $ownerRez->externalSites()->patch(2, [ "webhookRootUrl" => "tastier" ])->getBody();