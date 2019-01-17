<?php

namespace Spaceflora\DropboxApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

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
     * @var string
     */
    private $apiHost;

    /**
     * @var null|Client
     */
    private $client;

    /**
     * Request constructor.
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->apiHost = 'https://api.dropboxapi.com';
    }

    /**
     * @param string $endpoint
     * @param array  $parameters
     *
     * @return array
     */
    public function post(string $endpoint, array $parameters = [])
    {
        /** @var ResponseInterface $response */
        $response = $this->getClient()->post($this->apiHost.$endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $parameters,
        ]);

        return $this->parseResponse($response);
    }

    /**
     * @return \GuzzleHttp\Client|null
     */
    private function getClient(): \GuzzleHttp\Client
    {
        if (null === $this->client) {
            $this->client = new \GuzzleHttp\Client([
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);
        }

        return $this->client;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function parseResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
