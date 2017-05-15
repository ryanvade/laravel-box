<?php

namespace LaravelBox\Commands\Streams;

use LaravelBox\Commands\AbstractCommand;
use LaravelBox\Factories\ApiResponseFactory;

class UploadStreamContentsCommand extends AbstractCommand
{
    private $resource;
    private $remotePath;

    public function __construct(string $token, $resource, string $remotePath)
    {
        $this->token = $token;
        $this->resource = $resource;
        $this->remotePath = $remotePath;
        $this->folderId = parent::getFolderId(dirname($remotePath));
    }

    public function execute()
    {
        $token = $this->token;
        $cr = curl_init();
        $meta = stream_get_meta_data($this->resource);
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${token}",
        ];
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://upload.box.com/api/2.0/files/content');
        $json = json_encode([
            'name' => basename($this->remotePath),
            'parent' => [
                'id' => $this->folderId,
            ],
        ]);
        $fields = [
            'attributes' => $json,
            'file' => new \CurlFile($meta['uri'], mime_content_type($meta['uri']), basename($this->remotePath)),
        ];
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_POSTFIELDS, $fields);
        try {
            $response = curl_exec($cr);

            return ApiResponseFactory::build($response);
        } catch (Exception $e) {
            return ApiResponseFactory::build($e);
        } finally {
            curl_close($cr);
        }
    }
}
