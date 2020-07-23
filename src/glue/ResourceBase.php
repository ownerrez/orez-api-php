<?php

namespace OwnerRez\Api\Glue;

class ResourceBase
{
    protected string $resourcePath;
    protected Service $service;

    public function __construct(Service $service, string $resourcePath) {
        $this->service = $service;
        $this->resourcePath = $resourcePath;
    }

    function getSanatizedPath(string $path)
    {
        return str_replace('//', '/', $path);
    }

    public function get($actionOrId = null, array $query = null)
    {
        $path = $this->getSanatizedPath($this->resourcePath . '/' . $actionOrId);

        return $this->service->request('GET', $path, [ 'query' => $query ])->getBody();
    }

    public function patch(int $id, array $values)
    {
        $path = $this->resourcePath . '/' . $id;

        return $this->service->request('PATCH', $path, [ 'json' => $values ])->getBody();
    }

    public function post($actionOrId = null, array $values = null)
    {
        $path = $this->getSanatizedPath($this->resourcePath . '/' . $actionOrId);

        return $this->service->request('POST', $path, [ 'json' => $values ])->getBody();
    }
}