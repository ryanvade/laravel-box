<?php

namespace LaravelBox\Commands\Metadata;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class UpdateMetadataOnFileCommand extends AbstractMetadataTemplateCommand
{
    private $metadata;
    private $fileId;
    private $templateKey;

    public function __construct(string $token, string $fileId, string $templateKey, array $metadata)
    {
        $this->token = $token;
        $this->fileId = $fileId;
        $this->templateKey = $templateKey;
        $this->metadata = $metadata;
    }

    public function execute()
    {
        $token = $this->token;
        $url = "https://api.box.com/2.0/files/{$this->fileId}/metadata/enterprise/{$this->templateKey}";

        $body = [];
        foreach ($this->metadata as $key => $val) {
            $body[] = [
                "op" => "replace",
                "path" => "/".$key,
                "value" => $val,
            ];
        }
        $options = [
            'body' => json_encode($body),
            'replace',
            'headers' => [
                'Authorization' => "Bearer ${token}",
                'Content-Type' => "application/json-patch+json",
            ],
        ];

        try {
            $client = new Client();
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
