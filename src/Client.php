<?php

namespace Spaceflora\DropboxApi;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 */
class Client
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Client constructor.
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->request = new Request($accessToken);
    }

    /**
     * @param string $path
     *
     * @return array
     */
    public function download(string $path): array
    {
        return $this->request->post('/2/files/download', [
            'path' => $path,
        ]);
    }

    /**
     * @param string $path
     *
     * @return array
     */
    public function downloadZip(string $path): array
    {
        return $this->request->post('/2/files/download_zip', [
            'path' => $path,
        ]);
    }

    /**
     * @param string   $path
     * @param int|null $limit
     *
     * @return array
     */
    public function listFolder(string $path = '', int $limit = null): array
    {
        $parameters = [
            'path' => $path,
        ];

        if (null !== $limit) {
            $parameters['limit'] = $limit;
        }

        return $this->request->post('/2/files/list_folder', $parameters);
    }
}
