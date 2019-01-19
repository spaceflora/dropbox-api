<?php

namespace Spaceflora\DropboxApi;

/**
 * Class Service
 */
class Service
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Client constructor.
     *
     * @param string $accessToken
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array       $entry
     * @param string      $localPath
     * @param string|null $filename
     *
     * @return string
     */
    public function download(array $entry, string $localPath, string $filename = null): string
    {
        $path = $entry['path_lower'];

        if ('folder' === $entry['.tag']) {
            return $this->client->downloadZip(rtrim($path, '/').'/*');
        }

        return $this->client->download($path);
    }

    /**
     * @param array       $entry
     * @param string      $localPath
     * @param string|null $filename
     */
    public function export(array $entry, string $localPath, string $filename = null): void
    {
        $contents = $this->download($entry, $localPath, $filename);

        if (null !== $contents) {
            if (null === $filename) {
                $filename = $entry['name'];
            } else {
                $filename .= strstr($entry['name'], '.');
            }

            $path = rtrim($localPath, '/').'/'.$filename;
            $status = file_put_contents($path, $contents);

            if (false !== $status) {
                $this->client->delete($entry['path_lower']);
            }
        }
    }
}
