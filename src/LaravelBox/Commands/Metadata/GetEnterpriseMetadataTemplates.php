<?php

namespace LaravelBox\Commands\Metadata;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class GetEnterpriseMetadataTemplates extends AbstractMetadataTemplateCommand
{
    private $template;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function execute()
    {
        $token = $this->token;
        $url = "https://api.box.com/2.0/metadata_templates/enterprise";
        $options = [
            'body' => json_encode([]),
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
