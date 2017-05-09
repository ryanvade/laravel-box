<?php

namespace LaravelBox\Commands\Files;

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
        $cr = curl_init();
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${$this->token}",
        ];
        curl_setopt($cr, CURLOPT_CUSTOMREQUEST, 'OPTIONS');
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://api.box.com/api/2.0/files/content');
        $fields = [
            'name' => basename($this->localPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->remotePath)),
            ],
            'size' => filesize($this->localPath),
        ];
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_POSTFIELDS, $fields);
        try {
            $response = curl_exec($cr);
            // TODO return API Response
        } catch (Exception $e) {
            // TODO return API Response
        } finally {
            curl_close($cr);
        }
    }
}
