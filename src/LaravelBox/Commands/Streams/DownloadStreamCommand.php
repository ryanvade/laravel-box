<?php

namespace LaravelBox\Commands\Streams;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\stream_for;
use \LaravelBox\Commands\AbstractCommand;
use \LaravelBox\Factories\ApiResponseFactory;

class DownloadStreamCommand extends AbstractCommand {
    public function __construct(string $token, string $path)
    {
        $this->token = $token;
        $this->fileId = parent::getFileId($path);
        $this->folderId = parent::getFolderId(dirname($path));
    }

    public function execute()
    {
        $fileId = $this->fileId;
        $token = $this->token;

        $url = "https://api.box.com/2.0/files/${fileId}/content";
        $tmpFile = tmpfile();
        $stream = stream_for($tmpFile);
        $options = [
            'sink' => $stream,
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];

        try {
            $client = new Client();
            $resp = $client->request('GET', $url, $options);

            return ApiResponseFactory::build($resp, $stream);
        } catch (ClientException $e) {
            return ApiResponseFactory::build($e);
        } catch (ServerException $e) {
            return ApiResponseFactory::build($e);
        } catch (TransferException $e) {
            return ApiResponseFactory($e);
        } catch (RequestException $e) {
            return ApiResponseFactory($e);
        }
    }
}
