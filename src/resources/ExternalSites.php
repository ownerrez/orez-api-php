<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class ExternalSites extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'externalsites');
    }

    public function register($webhookUrl = null, $webhookToken = null): array
    {
        return parent::request('post', "register", null, ['webhookUrl' => $webhookUrl, 'webhookToken' => $webhookToken]);
    }
}
