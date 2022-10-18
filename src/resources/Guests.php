<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Guests extends ResourceBase
{
    public function __construct($service) {
        parent::__construct($service, 'guests');
    }

    public function list(string $q = null, $created_since_utc = null, bool $include_tags = null, bool $include_fields = null)
    {
        return parent::request('get', null, null, array(
            "q" => $q,
            "created_since_utc" => $created_since_utc,
            "include_tags" => $include_tags,
            "include_fields" => $include_fields
        ));
    }

    public function delete_phone(int $id, int $phone_id)
    {
        return parent::request('delete', "phones/" . $phone_id, $id);
    }

    public function delete_address(int $id, int $address_id)
    {
        return parent::request('delete', "addresses/" . $address_id, $id);
    }

    public function delete_email_address(int $id, int $email_address_id)
    {
        return parent::request('delete', "emailaddresses/" . $email_address_id, $id);
    }
}