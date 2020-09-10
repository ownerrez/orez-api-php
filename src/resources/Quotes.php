<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Quotes extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'quotes');
    }
}