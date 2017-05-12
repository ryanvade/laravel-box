<?php

namespace LaravelBox\Commands\Folders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class DeleteFolderCommand extends AbstractFolderCommand
{
    private $recursive;

    public function __construct(string $token, string $path, $recursive)
    {
        $this->token = $token;
        $this->recursive = $recursive;
        $this->folderId = parent::getFolderId($path);
    }

    public function execute()
    {
        $token = $this->token;
        $folderId = $this->folderId;
        $recursive = $this->recursive;
        $url = "https://api.box.com/2.0/folders/${folderId}";
        $options = [
            'query' => [
                'recursive' => ($recursive === true) ? 'true' : 'false',
            ],
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new Client();
            $resp = $client->request('DELETE', $url, $options);

            return ApiResponseFactory::build($resp);
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
