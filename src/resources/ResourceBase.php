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
        $path = $this->getSanatizedPath($this->resourcePath . '/' . $actionOrId);

        return $this->service->request('GET', $path, [ 'query' => $query ]);
    }

    public function patch(int $id, array $values)
    {
        $path = $this->resourcePath . '/' . $id;

        return $this->service->request('PATCH', $path, [ 'json' => $values ]);
    }
}