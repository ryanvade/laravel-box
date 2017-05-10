<?php

use LaravelBox\Factories\ApiResponseFactory;

namespace LaravelBox\Commands\Files;

class MoveFileCommand extends AbstractFileCommand
{
    private $newPath;
    private $oldPath;

    public function __construct(string $token, string $path, string $newPath)
    {
        $this->oldPath = $path;
        $this->newPath = $newPath;
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}";
        $body = [
            'name' => basename($this->newPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($newPath)),
            ],
        ];
        $options = [
            'header' => [
            'Authorization' => "Bearer ${$this->token}",
            ],
            'body' => $body,
        ];

        try {
            $client = new Client();
            $req = $client->request('PUT', $url, $headers);

            return ApiResponseFactory::build($req);
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
