<?php

namespace LaravelBox\Commands\Search;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;
use LaravelBox\Commands\AbstractCommand;

class SearchCommand extends AbstractCommand
{
    private $offset;
    private $limit;
    private $params;

    public function __construct(string $token, string $search, int $offset, int $limit, array $params)
    {
        $this->token = $token;
        $this->search = $search;
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
        $search = $this->search;
        $offset = $this->offset;
        $limit = $this->limit;
        $params = $this->params;
        $url = "https://api.box.com/2.0/search";

        $options = [
            'query' => [
                //'query' => $search,
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
