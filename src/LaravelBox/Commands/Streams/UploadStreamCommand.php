<?php

namespace LaravelBox\Commands\Streams;

use \LaravelBox\Commands\AbstractCommand;
use LaravelBox\Factories\ApiResponseFactory;

class UploadStreamCommand extends AbstractCommand {
    private $contents;
    private $remotePath;
    public function __construct(string $token, $contents, string $remotePath)
    {
        $this->token = $token;
        $this->contents = $contents;
        $this->remotePath = $remotePath;
    }

    public function execute()
    {
        $token = $this->token;
        $cr = curl_init();
        $fw = tmpfile();
        $meta = stream_get_meta_data($fw);
        fwrite($fw, $this->contents);
        rewind($fw);
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${token}",
        ];
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://upload.box.com/api/2.0/files/content');
        $json = json_encode([
            'name' => basename($this->remotePath),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->remotePath)),
            ],
        ]);
        $fields = [
            'attributes' => $json,
            'file' => curl_file_create($meta["uri"], 'text/plain', basename($this->remotePath)),
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
            fclose($fw);
        }
    }
}
