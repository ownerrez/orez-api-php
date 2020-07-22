<?php

namespace OwnerRez\Api\Glue;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

final class Service
{
    const API_VERSION = 'v1';

    private string $username;
    private string $accessToken;
    public Client $client;


    /**
     * Service constructor.
     * @param string $username
     * @param string $accessToken
     * @param string|null $apiRoot must end with a trailing slash
     */
    public function __construct(string $username, string $accessToken, string $apiRoot = null)
    {
        $this->username = $username;
        $this->accessToken = $accessToken;

        if ($apiRoot == null)
            $apiRoot = 'https://api.ownerreservations.com/';

        $baseUri = $apiRoot . self::API_VERSION . '/';

        $this->client = new Client([ 'base_uri' => $baseUri ]);
    }

    public function request($method, $resource, array $additionalOptions = null)
    {
        $options = [
            "headers" => [
                'User-Agent' => 'orez-api-php ' . self::API_VERSION,
                'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->accessToken),
                'Content-Type' => 'application/json',
                'Accepts' => 'application/json'
            ]
        ];

        if (isset($additionalOptions)) {
            foreach ($additionalOptions as $key => $value) {
                if (in_array($key, $options)) {
                    foreach ($value as $x => $y) {
                        $options[$key][$x] = $y;
                    }
                } else {
                    $options[$key] = $value;
                }
            }
        }

        try {
            return $this->client->request($method, $resource, $options);
        }catch (GuzzleException $e) {
            // Throw exception
            throw new \Exception('Request to ' . $resource . ' failed: ' . $e->getMessage());
        }
    }
}

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

/*
spl_autoload_register(function ($class)
{
    echo 'test';
    include 'resources/' . $class . '.php';
});*/