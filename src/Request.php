<?php

namespace Spaceflora\DropboxApi;

/**
 * Class Request
 */
class Request
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * Request constructor.
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string     $endpoint
     * @param array|null $parameters
     * @param array      $headers
     * @param bool       $isJson
     *
     * @return array|string
     */
    public function request(string $endpoint, array $parameters = null, array $headers = [], $isJson = true)
    {
        $headers['Authorization'] = 'Bearer '.$this->accessToken;

        if (true === $isJson) {
            $headers['Content-Type'] = 'application/json';
        }

        $output = $this->execute($endpoint, $parameters, $this->parseHeaders($headers));

        if (true === $isJson) {
            $output = json_decode($output, true);
        }

        return $output;
    }

    /**
     * @param string     $endpoint
     * @param array|null $parameters
     * @param array      $headers
     *
     * @return string
     */
    private function execute(string $endpoint, array $parameters = null, array $headers = []): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $endpoint);

        if (null !== $parameters) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
        }

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function parseHeaders(array $headers): array
    {
        $parsedHeaders = [];

        foreach ($headers as $headerKey => $headerValue) {
            $parsedHeaders[] = $headerKey.': '.$headerValue;
        }

        return $parsedHeaders;
    }
}
