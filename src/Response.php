<?php

namespace OwnerRez\Api;

class Response
{
    private string $raw_response;
    private array $raw_response_header;
    
    private array $headers = [];
    private int $status_code = 0;
    private ?\OwnerRez\Api\Exception $exception = null;

    private ?array $json = null;

    const HTTP_STATUS_CODE =
    [
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        426 => 'Upgrade Required',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    ];

    public function __construct(string $response, array $response_data, string $backEnd)
    {
        $this->raw_response = $response;

        if ($response !== false && ! empty($response_data) && is_array($response_data))
		{
            if ($backEnd == 'file_get_contents')
                $this->parseFileGetContents($response_data);
            else
                $this->parseCurl($response_data);
        }
        else
        {
            throw new Exception('Could not get remote response', 0, $this);
        }
    }

    private function parseRawResponseHeader(array $raw_response_header): void
    {
        $this->headers = [];
        $this->raw_response_header = $raw_response_header;

        foreach ($this->raw_response_header as $header)
        {
            if (strpos($header, ':') === false)
            {
                $this->headers[] = $header;
                continue;
            }

            list($key, $value) = explode(': ', $header, 2);

            // Fix case of header key
            $key = ucwords(strtolower($key), '-');
            
            if (isset($this->headers[$key]) && is_array($this->headers[$key]))
            {
                $this->headers[$key][] = $value;
            } elseif (isset($this->headers[$key]))
            {
                $this->headers[$key] = array($this->headers[$key], $value);
            } else
            {
                $this->headers[$key] = $value;
            }
        }
    }

    private function parseFileGetContents(array $response_data): void
    {
        $this->parseRawResponseHeader($response_data);

        if (preg_match('/(?P<version>HTTP\/[\d]+\.[\d]+)\s(?P<code>[\d]+)\s(?P<reason>.*)/', $this->raw_response_header[0], $status))
        {
            switch (substr($status['code'], 0, 1))
            {
                case 2: // Success
                case 3: // Redirection
                    $this->status_code = intval($status['code']);
                    break;
                case 4:
                case 5:
                    $this->status_code = intval($status['code']);

                    if (empty($status['reason']))
                    {
                        if (isset(self::HTTP_STATUS_CODE[$this->status_code]))
                        {
                            $status['reason'] = self::HTTP_STATUS_CODE[$this->status_code];
                        } else
                        {
                            $status['reason'] = 'Unknown';
                        }
                    }

                    $this->exception = new Exception($status['reason'], intval($status['code']), $this);
                break;
                default:
                    $this->exception = new Exception('Could not parse HTTP status (' . $this->raw_response_header[0] . ')', 0, $this);
            }
        } else
        {
            $this->exception = new Exception('Could not parse HTTP status (' . $this->raw_response_header[0] . ')', 0, $this);
        }
    }

    private function parseCurl(array $response_data): void
    {
        $this->status_code = $response_data['http_code'];

        // split raw_response into headers and body
        $headers = explode("\r\n", trim(substr($this->raw_response, 0, $response_data['header_size'])));
        $this->parseRawResponseHeader($headers);
        
        $this->raw_response = substr($this->raw_response, $response_data['header_size']);

        if ($this->status_code >= 400)
        {
            // Get error reason from status_code
            if (isset(self::HTTP_STATUS_CODE[$this->status_code]))
            {
                $reason = self::HTTP_STATUS_CODE[$this->status_code];
            } else
            {
                $reason = 'Unknown';
            }

            $this->exception = new Exception($reason, $this->status_code, $this);
        }
    }

    public function Throw(): void
    {
        if ($this->exception !== null)
        {
            throw $this->exception;
        }
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function getBody(): string
    {
        return $this->raw_response;
    }

    public function getJson(): array
    {
        if ($this->json === null)
        {
            $this->json = json_decode($this->raw_response, true);
        }

        return $this->json;
    }
}
