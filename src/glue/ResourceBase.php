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

    public function request(string $method, string $action = null, int $id = null, array $queryOrForm = null)
    {
        $path = $this->getSanatizedPath($this->resourcePath . '/' . $id . '/' . $action);
        $attachAt = 'json';

        if (strcasecmp($method, 'get') == 0)
            $attachAt = 'query';

        return $this->service->request(strtoupper($method), $path, [ $attachAt => $queryOrForm ])->getBody();
    }
}