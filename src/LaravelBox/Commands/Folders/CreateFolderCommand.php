<?php

namespace LaravelBox\Commands\Folders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class CreateFolderCommand extends AbstractFolderCommand
{
    private $path;

    public function __construct(string $token, string $path)
    {
        $this->token = $token;
        $this->path = $path;
    }

    public function execute()
    {
        $folders = explode("/", $this->path);
        $cnt = count($folders);
        if($cnt <= 2) // /Something or /
        {
            return $this->createFolder(basename($this->path), 0);
        }
        $resp = null;
        $parentIds = array_fill(0, $cnt, 0);
        for ($i=1; $i < $cnt; $i++) {
            $tmpFolders = explode("/", $this->path);
            $currPath = "/" . implode("/", array_splice($tmpFolders, 1, $i));
            $folderId = parent::getFolderId($currPath);
            if($folderId < 0)
            {
                $resp = $this->createFolder(basename($currPath), $parentIds[$i - 1]);
                $parentIds[$i] = parent::getFolderId($currPath);
            }else {
                $parentIds[$i] = $folderId;
            }

        }
        if($resp == null)
        {
            $resp = $this->createFolder(basename($this->path), $parentIds[$cnt - 1]);
        }
        return $resp;
    }

    private function createFolder(string $name, $parentId)
    {
        $token = $this->token;
        $url = "https://api.box.com/2.0/folders/";
        $options = [
            'body' => json_encode([
                'name' => $name,
                'parent' => [
                    'id' => $parentId,
                ],
            ]),
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new Client();
            $resp = $client->request('POST', $url, $options);

            return ApiResponseFactory::build($resp);
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
