<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Bookings extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'bookings');
    }

    public function availability(array $query): array
    {
        return parent::request('get', "availability", null, $query);
    }
}