<?php

namespace LaravelBox\Commands\Files;

use LaravelBox\Factories\ApiResponseFactory;

class PreflightCheckCommand extends AbstractFileCommand
{
    private $localPath;
    private $remotePath;

    public function __construct(string $token, string $localPath, string $remotePath)
    {
        $this->token = $token;
        $this->localPath = $localPath;
        $this->remotePath = $remotePath;
    }

    public function execute()
    {
        $token = $this->token;
        $cr = curl_init();
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${token}",
        ];
        curl_setopt($cr, CURLOPT_CUSTOMREQUEST, 'OPTIONS');
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://api.box.com/2.0/files/content');
        $fields = [
            'name' => basename($this->localPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->remotePath)),
            ],
            'size' => filesize($this->localPath),
        ];
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_POSTFIELDS, json_encode($fields));
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
