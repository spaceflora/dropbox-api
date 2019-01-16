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
}
