<?php

namespace OwnerRez\Api\Glue;

class ResourceBase
{
    protected string $resourcePath;
    protected \OwnerRez\Api\Glue\Service $service;

    public function __construct(\OwnerRez\Api\Glue\Service $service, string $resourcePath)
    {
        $this->service = $service;
        $this->resourcePath = $resourcePath;
    }

    protected function validate(array $item) { }

    private function getSanatizedPath(string $path): string
    {
        return str_replace('//', '/', $path);
    }

    public function request(string $method, string $action = null, int $id = null, array $queryOrFormData = null, $body = null) /*: mixed */
    {
        if ($body != null)
            $this->validate($body);

        $path = $this->getSanatizedPath($this->resourcePath . '/' . $id . '/' . $action);

        $options = null;
        $content = null;

        if ($body != null)
        {
            $content = json_encode($body);
        }
        else if ($queryOrFormData != null && !empty($queryOrFormData))
        {
            if (strcasecmp($method, 'get') == 0 or $body != null)
                $path .= '?' . http_build_query($queryOrFormData);
            else
                $content = json_encode($queryOrFormData);
        }

        $request = $this->service->request(strtoupper($method), $path, $content, $options);

        $request->Throw();

        return $request->getJson();
    }
}
