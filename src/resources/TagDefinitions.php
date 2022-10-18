<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class TagDefinitions extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'tagdefinitions');
    }

    public function list(bool $active = null)
    {
        return parent::request('get', null, null, array(
            "active" => $active
        ));
    }
}