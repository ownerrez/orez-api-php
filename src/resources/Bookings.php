<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Bookings extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'bookings');
    }

    public function availability(array $query)
    {
        return parent::request('get', "availability", null, $query);
    }
}