<?php

namespace OwnerRez\Api\Resources;

class Properties extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'properties');
    }
}