<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Fields extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'fields');
    }

    public function list(int $entity_id, int $entity_type)
    {
        return parent::request('get', null, null, array(
            "entity_id" => $entity_id,
            "entity_type" => $entity_type
        ));
    }

    public function delete_by_definition(int $field_definition_id, int  $entity_id, int $entity_type)
    {
        return parent::request('delete', "bydefinition", null, array(
            "field_definition_id" => $field_definition_id,
            "entity_id" => $entity_id,
            "entity_type" => $entity_type
        ));
    }
}