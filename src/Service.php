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
     * Service constructor.
     *
     * @param Client $client
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
     * @return bool
     */
    public function download(array $entry, string $localPath, string $filename = null): bool
    {
        $path = $entry['path_lower'];

        if ('folder' === $entry['.tag']) {
            $contents = $this->client->downloadZip($path);
        } else {
            $contents = $this->client->download($path);
        }

        $status = false;

        if (null !== $contents) {
            if (null === $filename) {
                $filename = $entry['name'];
            } else {
                $filename .= strstr($entry['name'], '.');
            }

            if ('folder' === $entry['.tag']) {
                $filename .= '.zip';
            }

            $path = rtrim($localPath, '/').'/'.$filename;
            $status = file_put_contents($path, $contents);

            if (false !== $status) {
                $status = true;
            }
        }

        return $status;
    }

    /**
     * @param array       $entry
     * @param string      $localPath
     * @param string|null $filename
     */
    public function export(array $entry, string $localPath, string $filename = null): void
    {
        $status = $this->download($entry, $localPath, $filename);

        if (true === $status) {
            $this->client->delete($entry['path_lower']);
        }
    }
}
