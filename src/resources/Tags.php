<?php

namespace OwnerRez\Api\Resources;

use OwnerRez\Api\Glue\ResourceBase;

class Tags extends ResourceBase
{
    public function __construct(\OwnerRez\Api\Glue\Service $service)
    {
        parent::__construct($service, 'tags');
    }

    static array $integerProperties = [ 'tagGroupId' ];

    protected function validate(array $item)
    {
        foreach (self::$integerProperties as &$prop) {
            if (key_exists($prop, $item) && !empty($item[$prop]) && !is_numeric($item[$prop]))
                throw new \Exception("The field '" . $prop . "' must be an integer value!");
        }

        parent::validate($item);
    }
}
