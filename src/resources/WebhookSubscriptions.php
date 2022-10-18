<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class WebhookSubscriptions extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'webhooksubscriptions');
    }

    public function list()
    {
        return parent::request("get");
    }

    protected function patch($id, $jsonbody)
    {
        throw new \Exception("The PATCH verb is not defined for Users.");
    }
}