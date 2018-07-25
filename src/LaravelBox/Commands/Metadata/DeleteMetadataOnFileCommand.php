<?php

namespace LaravelBox\Commands\Metadata;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class DeleteMetadataOnFileCommand extends AbstractMetadataTemplateCommand
{
    private $metadata;
    private $fileId;
    private $templateKey;

    public function __construct(string $token, string $fileId, string $templateKey)
    {
        $this->token = $token;
        $this->fileId = $fileId;
        $this->templateKey = $templateKey;
    }

    public function execute()
    {
        $token = $this->token;
        $url = "https://api.box.com/2.0/files/{$this->fileId}/metadata/enterprise/{$this->templateKey}";

        $options = [
            'headers' => [
                'Authorization' => "Bearer ${token}",
                'Content-Type' => "application/json",
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
