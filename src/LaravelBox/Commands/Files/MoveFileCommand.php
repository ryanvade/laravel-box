<?php

namespace LaravelBox\Commands\Files;

class MoveFileCommand extends AbstractFileCommand
{
    private $newPath;
    private $oldPath;

    public function __construct(string $token, string $path, string $newPath)
    {
        $this->oldPath = $path;
        parent::_construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        // Cases:
        $newFileName = basename($this->newPath);
        $newFolderName = dirname($this->newPath);
        // A) Original File does not exist
        if (!$this->fileExists($this->fileId)) {
            return false;
        }
        // B) New Path does not exist
        if (!$this->folderExists($this->getFolderId($newFolderName))) {
            // TODO CREATE FOLDER
        } elseif ($this->fileExists($this->getFileId($this->newPath))) {
            // C) New Path Exists and new file name does exist
            $counter = 1;
            $newPath .= '.'.$counter;
            while ($this->fileExists($this->getFileId($this->newPath))) {
                ++$counter;
                $newPath .= '.'.$counter;
            }
            // New file name is file.ext.#
            return $this->execute();
        } else {
            // D) New Path Exists and new file name does not exist

            // DOWNLOAD REMOTE FILLE
            $resp = $this->downloadFile();
            if ($resp instanceof ApiResponse) {
                return $resp;
            }
            // DELETE REMOTE FILE
            $resp = $this->deleteFile();
            if ($resp instanceof ApiResponse) {
                return $resp;
            }
            // UPLOAD NEW FILE
            return $this->uploadFile();
        }
    }

    private function downloadFile()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}/content";
        $resource = fopen(dirname(config('laravelbox.storage-location')).basename($this->oldPath), 'rw');
        $options = [
            'sink' => $resource,
            'headers' => [
                'Authorization' => "Bearer ${$this->token}",
            ],
        ];
        try {
            $dl_req = $client->request('GET', $url, $options);

            return true;
        } catch (ClientException $e) {
            // TODO: RETURN Error API Response
        }
    }

    private function deleteFile()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}";
        $options = [
            'headers' => [
                'Authorization' => "Bearer ${$this->token}",
            ],
        ];
        try {
            $del_rq = $client->request('DELETE', $url, $options);

            return true;
        } catch (ClientException $e) {
            // TODO return Error API Response
        }
    }

    private function uploadFile()
    {
        $cr = curl_init();
        $headers = [
            'Content-Type: multipart/form-data',
            "Authorization: Bearer ${$this->token}",
        ];
        curl_setopt($cr, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cr, CURLOPT_URL, 'https://upload.box.com/api/2.0/files/content');
        $json = json_encode([
            'name' => basename($this->path),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->newPath)),
            ],
        ]);
        $fields = [
            'attributes' => $json,
            'file' => new CurlFile(basename($this->localPath), mime_content_type(basename($this->path)), basename($this->newPath)),
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
