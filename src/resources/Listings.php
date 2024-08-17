<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Listings extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'listings');
    }

    public function summary(array $query, $id = null): array
    {
        return parent::request('get', 'summary', $id, $query);
    }

    public function pricing(array $query, $id): array
    {
        return parent::request('get', 'summary', $id, $query);
    }

    public function availability(array $query, $id = null): array
    {
        return parent::request('get', 'summary', $id, $query);
    }
}
