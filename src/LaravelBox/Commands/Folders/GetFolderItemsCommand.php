<?php

namespace LaravelBox\Commands\Folders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class GetFolderItemsCommand extends AbstractFolderCommand
{
    private $offset;
    private $limit;

    public function __construct(string $token, string $path, int $offset, int $limit)
    {
        $this->token = $token;
        $this->folderId = parent::getFolderId($path);
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function execute()
    {
        $token = $this->token;
        $folderId = $this->folderId;
        $offset = $this->offset;
        $limit = $this->limit;
        $url = "https://api.box.com/2.0/folders/${folderId}/items";
        $options = [
            'query' => [
                'offset' => ($offset >= 0) ? $offset : 0,
                'limit' => ($limit >= 1) ? ($limit <= 1000) ? $limit : 1000 : 1,
            ],
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new Client();
            $resp = $client->request('GET', $url, $options);

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
