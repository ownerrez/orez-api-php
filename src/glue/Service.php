<?php

namespace OwnerRez\Api\Glue;

use OwnerRez\Api\Client;

final class Service
{
    const API_VERSION = 'v1';

    private string $username;
    private string $accessToken;
    private string $baseUri;

    private bool $supportsFileGetContents;
    private bool $supportsCurl;
    private string $backEnd;
    private bool $associative = false;

    /**
     * Service constructor.
     * @param string $username
     * @param string $accessToken
     * @param string|null $apiRoot must end with a trailing slash
     * @param string|null $backEnd 'file_get_contents' or 'curl' backend for requests
     * @param bool $associative return associative arrays instead of objects
     */
    public function __construct(string $username, string $accessToken, ?string $apiRoot = null, ?string $backEnd = null, bool $associative = false)
    {
        $this->username = $username;
        $this->accessToken = $accessToken;
        $this->associative = $associative;

        if ($apiRoot == null)
            $apiRoot = 'https://api.ownerrez.com/';

        $this->baseUri = $apiRoot . self::API_VERSION . '/';

        if (\function_exists('file_get_contents') && \ini_get('allow_url_fopen') == 1 && in_array('https', \stream_get_wrappers()))
            $this->supportsFileGetContents = true;
        else
            $this->supportsFileGetContents = false;

        if (\function_exists('curl_init'))
            $this->supportsCurl = true;
        else
            $this->supportsCurl = false;

        if ($backEnd != 'curl' && $this->supportsFileGetContents)
            $this->backEnd = 'file_get_contents';
        else if ($backEnd != 'file_get_contents' && $this->supportsCurl)
            $this->backEnd = 'curl';
        else
            throw new \Exception('No backend available');
    }

    /**
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $uri URI to request
     * @param array|null $additionalOptions Additional options to pass to the \stream_context_create
     */
    public function request($method, $uri, ?string $content = null, ?array $additionalOptions = null): \OwnerRez\Api\Response
    {
        if ($this->backEnd == 'file_get_contents')
            return $this->useFileGetContents($method, $uri, $content, $additionalOptions);
        else if ($this->backEnd == 'curl')
            return $this->useCurl($method, $uri, $content, $additionalOptions);
        else
            throw new \Exception('No backend available');
    }

    public function getBackEnd(): string
    {
        return $this->backEnd;
    }

    private function useFileGetContents($method, $uri, ?string $content = null, ?array $additionalOptions = null): \OwnerRez\Api\Response
    {
        $options =
        [
            'http' =>
            [
                'method' => $method,
                'user_agent' => 'orez-api-php/' . Client::VERSION,
                'content' => $content,
                'ignore_errors' => true,
                'header' =>
                [
                    'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->accessToken),
                    'Accept' => 'application/json'
                ]
            ]
        ];

        if ($content != null)
            $options['http']['header']['Content-Type'] = 'application/json';

        if ($additionalOptions != null)
            $options = array_merge_recursive($options, $additionalOptions);

        $context = \stream_context_create($options);

        $headers = [];

        foreach ($options['http']['header'] as $key => $value)
            $headers[$key] = "{$key}: {$value}";

        \stream_context_set_option($context, 'http', 'header', $headers);

        $response = \file_get_contents($this->baseUri . $uri, false, $context);

        return new \OwnerRez\Api\Response($response, $http_response_header, 'file_get_contents', $this->associative);
    }

    private function useCurl($method, $uri, ?string $content = null, ?array $additionalOptions = null): \OwnerRez\Api\Response
    {
        try
        {
            $ch = \curl_init();

            $headers =
            [
                'Authorization: Basic ' . base64_encode($this->username . ':' . $this->accessToken),
                'Accept: application/json'
            ];

            \curl_setopt($ch, \CURLOPT_URL, $this->baseUri . $uri);
            \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
            \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true);
            \curl_setopt($ch, \CURLOPT_HEADER, true);
            \curl_setopt($ch, \CURLOPT_USERAGENT, 'orez-api-php/' . Client::VERSION);

            if (strpos($this->baseUri, '.dev.') !== false)
                \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);

            if ($content != null)
            {
                \curl_setopt($ch, \CURLOPT_POST, true);
                \curl_setopt($ch, \CURLOPT_POSTFIELDS, $content);
                $headers[] = 'Content-Type: application/json';
            }

            \curl_setopt($ch, \CURLOPT_HTTPHEADER, $headers);

            if ($additionalOptions != null)
                \curl_setopt_array($ch, $additionalOptions);

            $response = \curl_exec($ch);

            if ($response === false)
                throw new \Exception(\curl_error($ch), \curl_errno($ch));

            return new \OwnerRez\Api\Response($response, \curl_getinfo($ch), 'curl', $this->associative);
        }
        finally
        {
            \curl_close($ch);
        }
    }
}
