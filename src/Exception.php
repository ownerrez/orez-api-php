<?php

namespace OwnerRez\Api;

class Exception extends \RuntimeException
{
    public readonly \OwnerRez\Api\Response $response;

    public function __construct($message, $code = 0, \OwnerRez\Api\Response $response, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }
}
