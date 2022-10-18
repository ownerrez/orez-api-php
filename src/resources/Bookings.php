<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Bookings extends ResourceBase
{
    public function __construct($service)
    {
        parent::__construct($service, 'bookings');
    }

    public function list(array $property_ids = null, $from = null, $to = null, $since_utc = null, bool $include_door_codes = null, bool $include_charges = null, bool $include_tags = null, bool $include_fields = null)
    {
        $query = array(
            "property_ids" => $property_ids,
            "from" => $from,
            "to" => $to,
            "since_utc" => $since_utc,
            "include_door_codes" => $include_door_codes,
            "include_charges" => $include_charges,
            "include_tags" => $include_tags,
            "include_fields" => $include_fields
        );

        return parent::request('get', null, null, $query);
    }

    protected function post($jsonbody)
    {
        throw new \Exception("The POST verb is not defined for Bookings.");
    }

    protected function delete($id)
    {
        throw new \Exception("The DELETE verb is not defined for Bookings.");
    }
}