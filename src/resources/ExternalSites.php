<?php

namespace OwnerRez\Api\Resources;

class ExternalSites extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'externalsites');
    }
}