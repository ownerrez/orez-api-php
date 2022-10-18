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
        return parent::request('get', 'me');
    }

    protected function get($id)
    {
        throw new \Exception("The GET verb is not defined for Users.");
    }

    protected function post($jsonbody)
    {
        throw new \Exception("The POST verb is not defined for Users.");
    }

    protected function delete($id)
    {
        throw new \Exception("The DELETE verb is not defined for Users.");
    }
}