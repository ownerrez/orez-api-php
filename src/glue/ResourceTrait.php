<?php

namespace OwnerRez\Api\Glue;

trait ResourceTrait
{
    public function get(int $id)
    {
        return parent::request("get", null, $id);
    }

    public function post(string $jsonbody)
    {
        return parent::request("post", null, null, null, $jsonbody);
    }

    public function patch(int $id, string $jsonbody)
    {
        return parent::request("patch", null, $id, null, $jsonbody);
    }

    public function delete(int $id)
    {
        return parent::request("delete", null, $id);
    }
}