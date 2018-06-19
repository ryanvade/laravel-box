<?php

namespace LaravelBox\Api;

use LaravelBox\ApiResponseFactory;

class Files extends Api
{
    public function copy(string $fromPath, string $toPath)
    {
        $fileId = $this->getFileId($fromPath);
        $folderId = $this->getFolderId(dirname($toPath));

        $url = $this->config->baseUrl() . "files/${fileId}/copy";

        $body = [
          'parent' => [
            'id' => "${folderId}"
          ]
        ];

        $options = [
          'body' => json_encode($body),
          'headers' => [
            'Authorization' => $this->config->getAuthHeader()
          ]
        ];

        try {
            $req = $this->config->client->request('POST', $url, $options);

            return ApiResponseFactory::build($req);
        } catch (ClientException $e) {
            return ApiResponseFactory::build($e);
        } catch (ServerException $e) {
            return ApiResponseFactory::build($e);
        } catch (TransferException $e) {
            return ApiResponseFactory::build($e);
        } catch (RequestException $e) {
            return ApiResponseFactory::build($e);
        }
    }

    public function delete(string $path)
    {
        $fileId = $this->getFileId($path);

        $url = $this->config->baseUrl() . "files/${fileId}";


        $options = [
          'headers' => [
            'Authorization' => $this->config->getAuthHeader()
          ]
        ];

        try {
            $req = $this->config->client->request('DELETE', $url, $options);

            return ApiResponseFactory::build($req);
        } catch (ClientException $e) {
            return ApiResponseFactory::build($e);
        } catch (ServerException $e) {
            return ApiResponseFactory::build($e);
        } catch (TransferException $e) {
            return ApiResponseFactory::build($e);
        } catch (RequestException $e) {
            return ApiResponseFactory::build($e);
        }
    }

    public function download(string $fromPath, string $toPath)
    {
        $fileId = $this->getFileId($path);

        $url = $this->config->baseUrl() . "files/${fileId}/content";


        $options = [
          'sink' => fopen($fromPath, 'w'),
          'headers' => [
            'Authorization' => $this->config->getAuthHeader()
          ]
        ];

        try {
            $req = $this->config->client->request('GET', $url, $options);

            return ApiResponseFactory::build($req);
        } catch (ClientException $e) {
            return ApiResponseFactory::build($e);
        } catch (ServerException $e) {
            return ApiResponseFactory::build($e);
        } catch (TransferException $e) {
            return ApiResponseFactory::build($e);
        } catch (RequestException $e) {
            return ApiResponseFactory::build($e);
        }
    }

    public function collaborations(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}/collaborations";


      $options = [
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function comments(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}/comments";


      $options = [
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function embedlink(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}";


      $options = [
        'query' => [
            'fields' => 'expiring_embed_link',
        ],
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function tasks(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}/tasks";


      $options = [
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function thumbnail(string $path, string $extension)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}/thumbnail.{$extension}";


      $options = [
        'sink' => fopen($path, 'w'),
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function information(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}";


      $options = [
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function lock(string $path)
    {
      $fileId = $this->getFileId($path);

      $url = $this->config->baseUrl() . "files/${fileId}/tasks";

      $body = [
          'lock' => [
              'type' => 'lock',
              //TODO Lock Expiration Date
              //TODO Lock Download Prevented
          ],
      ];

      $options = [
        'body' => json_encode($body),
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('PUT', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function move(string $fromPath, string $toPath)
    {
      $fileId = $this->getFileId($fromPath);
      $folderId = $this->getFolderId(dirname($toPath));

      $url = $this->config->baseUrl() . "files/${fileId}";

      $body = [
        'name' => basename($toPath),
        'parent' => [
            'id' => $folderId
        ],
      ];

      $options = [
        'body' => json_encode($body),
        'headers' => [
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('PUT', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function preflightCheck(string $fromPath, string $toPath)
    {
      $fileId = $this->getFileId($fromPath);
      $folderId = $this->getFolderId(dirname($toPath));

      $url = $this->config->baseUrl() . "files/content";

      $body = [
        'name' => basename($toPath),
        'parent' => [
            'id' => $folderId
        ],
        'size' => filesize($this->localPath),
      ];

      $options = [
        'body' => json_encode($body),
        'headers' => [
          'Content-Type: multipart/form-data',
          'Authorization' => $this->config->getAuthHeader()
        ]
      ];

      try {
          $req = $this->config->client->request('OPTIONS', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function unlock(string $path)
    {
      $fileId = $this->getFileId($fromPath);

      $url = $this->config->baseUrl() . "files/${fileId}";

      $body = [
          'lock' => [
              'type' => null,
              //TODO Lock Expiration Date
              //TODO Lock Download Prevented
          ],
      ];

      $options = [
          'body' => json_encode($body),
          'query' => [
              'fields' => 'lock',
          ],
          'headers' => [
              'Authorization' => $this->config->getAuthHeader()
          ],
      ];

      try {
          $req = $this->config->client->request('PUT', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function upload(string $fromPath, string $toPath)
    {
      $folderId = $this->getFolderId(dirname($this->toPath));

      $url = $this->config->baseUrl() . "files/content";

      $fileInfo = [
        'name' => basename($toPath),
        'parent' => [
          'id' => $this->getFolderId(dirname($toPath))
        ]
      ];

      $options = [
        'headers' => [
          'Content-Type: multipart/form-data',
          'Authorization' => $this->config->getAuthHeader()
        ],
        'multipart' => [
          [
            'name' => 'FileContents',
            'contents' => file_get_contents($fromPath),
            'filename' => basename($fromPath)
          ],
          [
            'name' => 'FileInfo',
            'contents' => json_encode($fileInfo)
          ]
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }

    public function uploadVersion(string $fromPath, string $toPath)
    {
      $fileId = $this->getFileId($toPath);
      $folderId = $this->getFolderId(dirname($toPath));

      $url = $this->config->baseUrl() . "files/${fileId}/content";

      $fileInfo = [
        'name' => basename($toPath),
        'parent' => [
          'id' => $this->getFolderId(dirname($toPath))
        ]
      ];

      $options = [
        'headers' => [
          'Content-Type: multipart/form-data',
          'Authorization' => $this->config->getAuthHeader()
        ],
        'multipart' => [
          [
            'name' => 'FileContents',
            'contents' => file_get_contents($fromPath),
            'filename' => basename($fromPath)
          ],
          [
            'name' => 'FileInfo',
            'contents' => json_encode($fileInfo)
          ]
        ]
      ];

      try {
          $req = $this->config->client->request('GET', $url, $options);

          return ApiResponseFactory::build($req);
      } catch (ClientException $e) {
          return ApiResponseFactory::build($e);
      } catch (ServerException $e) {
          return ApiResponseFactory::build($e);
      } catch (TransferException $e) {
          return ApiResponseFactory::build($e);
      } catch (RequestException $e) {
          return ApiResponseFactory::build($e);
      }
    }
}
