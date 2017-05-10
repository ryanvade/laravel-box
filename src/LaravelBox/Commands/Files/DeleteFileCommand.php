<?php

use LaravelBox\Factories\ApiResponseFactory;

namespace LaravelBox\Commands\Files;

class DeleteFileCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}";
        $options = [
            'headers' => [
                'Authorization' => "Bearer ${$token}",
            ],
        ];
        try {
            $client = new Client();
            $req = $client->request('DELETE', $url, $options);

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
