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

    public function __construct(string $token, string $path, array $params, int $offset, int $limit)
    {
        $this->token = $token;
        $this->folderId = parent::getFolderId($path);
        $this->offset = $offset;
        $this->limit = $limit;
        $this->params = $params;

        if (empty($this->params)) {
          $this->params = ['fields' => 'modified_at,path_collection,name,size'];
        }
    }

    public function execute()
    {
        $token = $this->token;
        $folderId = $this->folderId;
        $offset = $this->offset;
        $limit = $this->limit;
        $params = $this->params;
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
        $options['query'] = array_merge($options['query'], $params);
        
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
