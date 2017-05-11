<?php

namespace LaravelBox\Commands\Files;

use LaravelBox\Factories\ApiResponseFactory;

class UploadFileCommand extends AbstractFileCommand
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
        $fileId = $this->fileId;
        $cr = curl_init();
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${token}",
        ];
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://upload.box.com/api/2.0/files/content');
        $json = json_encode([
            'name' => basename($this->localPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->remotePath)),
            ],
        ]);
        $fields = [
            'attributes' => $json,
            'file' => new \CurlFile(basename($this->localPath), mime_content_type(basename($this->localPath)), basename($this->remotePath)),
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
