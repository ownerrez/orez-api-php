<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Guests extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'guests');
    }
}