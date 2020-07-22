<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Users extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'users');
    }

    public function me()
    {
        return parent::get('me');
    }
}