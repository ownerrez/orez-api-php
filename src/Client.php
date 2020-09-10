<?php

namespace OwnerRez\Api;

use OwnerRez\Api\Glue\Service;

final class Client
{
    private Service $service;

    public function __construct(string $username, string $accessToken, string $apiRoot = null)
    {
        $this->service = new Service($username, $accessToken, $apiRoot);
    }

    public function externalSites()
    {
        return new Resources\ExternalSites($this->service);
    }

    public function properties()
    {
        return new Resources\Properties($this->service);
    }

    public function quotes()
    {
        return new Resources\Quotes($this->service);
    }

    public function users()
    {
        return new Resources\Users($this->service);
    }
}