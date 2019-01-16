<?php

namespace Spaceflora\DropboxApi;

/**
 * Class Client
 */
class Client
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
     * @var null|\GuzzleHttp\Client
     */
    private $client;

    /**
     * Client constructor.
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->apiHost = 'https://api.dropboxapi.com';
    }

    public function listFolder(string $path = '')
    {
        /** @var REsponse $response */
        $response = $this->getClient()->post($this->apiHost.'/2/files/list_folder', [
            \GuzzleHttp\RequestOptions::JSON => [
                'path' => $path,
            ],
        ]);

        return $response;
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
}
