<?php

namespace Spaceflora\DropboxApi;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 */
class Client
{
    const CONTENT_TYPE = 'Content-Type';
    const DROPBOX_API_ARG = 'Dropbox-API-Arg';

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
    public function delete(string $path): array
    {
        return $this->request->request('https://api.dropboxapi.com/2/files/delete_v2', [
            'path' => $path,
        ]);
    }

    /**
     * @param string $path
     * @param string $localPath
     *
     * @return string
     */
    public function download(string $path): string
    {
        return $this->request->request('https://content.dropboxapi.com/2/files/download', null, [
            self::DROPBOX_API_ARG => sprintf('{"path":"%s"}', $path),
            self::CONTENT_TYPE => 'application/octet-stream',
        ], false);
    }

    /**
     * @param string $path
     * @param string $localPath
     *
     * @return string
     */
    public function downloadZip(string $path): string
    {
        return $this->request->request('https://content.dropboxapi.com/2/files/download_zip', null, [
            self::DROPBOX_API_ARG => sprintf('{"path":"%s"}', $path),
            self::CONTENT_TYPE => 'application/octet-stream',
        ], false);
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

        return $this->request->request('https://api.dropboxapi.com/2/files/list_folder', $parameters);
    }
}
