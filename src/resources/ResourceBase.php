<?php


namespace OwnerRez\Api\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use OwnerRez\Api\Glue\Service;

class ResourceBase
{
    protected string $resourcePath;
    protected Service $service;

    public function __construct(Service $service, $resourcePath) {
        $this->service = $service;
        $this->resourcePath = $resourcePath;
    }

    function getSanatizedPath($path)
    {
        return str_replace('//', '/', $path);
    }

    public function get($actionOrId = null, $query = null)
    {
        $args = func_get_args();
        $path = $this->getSanatizedPath($this->resourcePath . '/' . $actionOrId);
//        $query = [];
//
//        if (count($args) > 0)
//        {
//            $path = $this->getSanatizedPath( $path . $args[0]);
//
//            if (count($args) > 1)
//                $query = array_slice($args, 1);
//        }

        return $this->service->request('GET', $path, [ 'query' => $query ]);
    }
}