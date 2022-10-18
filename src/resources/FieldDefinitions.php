<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class FieldDefinitions extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'fielddefinitions');
    }

    public function list($type = null, bool $active = null)
    {
        return parent::request('get', null, null, array(
            "type" => $type,
            "active" => $active
        ));
    }
}