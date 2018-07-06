<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class TagFileCommand extends AbstractFileCommand
{
    private $tags;
    private $params;

    public function __construct(string $token, $path, array $tags)
    {
        $this->tags = $tags;
        $this->token = $token;
        if (is_numeric($path)) {
            $this->fileId = $path;
        }
        else {
            $this->fileId = parent::getFileId($path);
        }
        if (empty($this->params)) {
          $this->params = ['fields' => 'modified_at,path_collection,name,size,tags'];
        }
    }

    public function execute()
    {
        $fileId = $this->fileId;
        $token = $this->token;
        $url = "https://api.box.com/2.0/files/${fileId}";
        $body = [
            'tags' => $this->tags,
        ];
        $options = [
            'query' => [],
            'headers' => [
            'Authorization' => "Bearer ${token}",
            ],
            'body' => json_encode($body),
        ];
        $options['query'] = array_merge($options['query'], $this->params);

        try {
            $client = new \GuzzleHttp\Client();
            $req = $client->request('PUT', $url, $options);

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
