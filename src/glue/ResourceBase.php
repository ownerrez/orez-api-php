<?php

namespace OwnerRez\Api\Glue;

class ResourceBase
{
    protected $resourcePath;
    protected $service;

    public function __construct(Service $service, string $resourcePath) {
        $this->service = $service;
        $this->resourcePath = $resourcePath;
    }

    protected function validate(array $item) { }

    function getSanatizedPath(string $path)
    {
        return str_replace('//', '/', $path);
    }

    public function request(string $method, string $action = null, int $id = null, array $queryOrFormData = null, $body = null)
    {
        if ($body != null)
            $this->validate($body);

        $path = $this->getSanatizedPath($this->resourcePath . '/' . $id . '/' . $action);

        $options = null;

        if ($body != null) {
            $options = [ 'body' => json_encode($body) ];
        }
        else {
            $attachAt = 'json';

            if (strcasecmp($method, 'get') == 0 or $body != null)
                $attachAt = 'query';

            $options = [ $attachAt => $queryOrFormData ];
        }

        return $this->service->request(strtoupper($method), $path, $options)->getBody();
    }
}