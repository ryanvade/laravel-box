<?php

namespace LaravelBox\Commands\Metadata;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class CreateMetadataTemplateCommand extends AbstractMetadataTemplateCommand
{
    private $template;

    public function __construct(string $token, array $template)
    {
        $this->template = $template;
        $this->token = $token;
    }

    public function execute()
    {
        $token = $this->token;
        $url = "https://api.box.com/2.0/metadata_templates/schema";
        $body = $this->template;
        $options = [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];

        try {
            $client = new Client();
            $req = $client->request('POST', $url, $options);
            $message = $req->getMessage();
            $body = $req->__toString();
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
