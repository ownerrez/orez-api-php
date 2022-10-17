<?php

namespace OwnerRez\Api;

use OwnerRez\Api\Glue\Service;

final class Client
{
    private $service;

    public function __construct(string $username, string $accessToken, string $apiRoot = null)
    {
        $this->service = new Service($username, $accessToken, $apiRoot);
    }

    public function bookings(): Resources\Bookings
    {
        return new Resources\Bookings($this->service);
    }

    public function externalSites(): Resources\ExternalSites
    {
        return new Resources\ExternalSites($this->service);
    }

    public function guests(): Resources\Guests
    {
        return new Resources\Guests($this->service);
    }

    public function listings(): Resources\Listings
    {
        return new Resources\Listings($this->service);
    }

    public function properties(): Resources\Properties
    {
        return new Resources\Properties($this->service);
    }

    public function quotes(): Resources\Quotes
    {
        return new Resources\Quotes($this->service);
    }

    public function tags(): Resources\Tags
    {
        return new Resources\Tags($this->service);
    }

    public function users(): Resources\Users
    {
        return new Resources\Users($this->service);
    }
}
