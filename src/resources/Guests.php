<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Guests extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, "guests");
    }

    public function get(string $q, int $limit = null)
    {
        $args = [
          "q" => $q,
          "limit" => $limit
        ];

        return parent::request("get", null, null, $args);
    }

    public function delete(int $id)
    {
        return parent::request("delete", null, $id);
    }
}