<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Quotes extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'quotes');
    }

    static array $integerProperties = [ 'adults', 'children', 'infants', 'pets', 'guestId', 'propertyId', 'inquiryId', 'agreementId', 'listingSiteId' ];

    protected function validate(array $item)
    {
        foreach (self::$integerProperties as &$prop) {
            if (key_exists($prop, $item) && !empty($item[$prop]) && !is_numeric($item[$prop]))
                throw new \Exception("The field '" . $prop . "' must be an integer value!");
        }

        parent::validate($item);
    }
}
