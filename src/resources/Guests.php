<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Guests extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'guests');
    }
}
