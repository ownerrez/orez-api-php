<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Tags extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'tags');
    }

    public function list(int $entity_id, int $entity_type)
    {
        return parent::request('get', null, null, array(
            "entity_id" => $entity_id,
            "entity_type" => $entity_type
        ));
    }

    public function delete_by_name(string $name, int $entity_id, int $entity_type)
    {
        return parent::request('delete', "byname", null, array(
            "name" => $name,
            "entity_id" => $entity_id,
            "entity_type" => $entity_type
        ));
    }

    protected function patch(int $id, string $jsonbody)
    {
        throw new \Exception("The PATCH verb is not defined for Tags.");
    }
}