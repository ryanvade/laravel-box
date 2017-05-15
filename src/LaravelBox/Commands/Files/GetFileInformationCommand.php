<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use LaravelBox\Factories\ApiResponseFactory;

class GetFileInformationCommand extends AbstractFileCommand
{
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
        $url = "https://api.box.com/2.0/files/${fileId}";
        $options = [
        'headers' => [
            'Authorization' => "Bearer ${token}",
        ],
        ];

        try {
            $client = new Client();
            $req = $client->request('GET', $url, $options);

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
