<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelBox\Commands\Files\AbstractFileCommand;

namespace LaravelBox\Commands\Files;

class GetFileInformationCommand extends AbstractFileCommand
{
  public function __construct(string $token, string $fileId)
  {
    parent::__construct($token, $fileId);
  }

  private function execute()
  {
    $url = "https://api.box.com/2.0/files/${$this->fileId}";
    $headers = [
      'headers' => [
        'Authorization' => "Bearer ${$this->token}"
      ],
    ];
    $client = parent::getInstance();
    return $client->get($url, $headers);
  }

  public function getResponse()
  {
    $resp = $this->execute();
    $status = [];
    if(!$resp instanceof Response )
      $status['success'] = 'error';
    else
    {
      $status['success'] = $resp->getReasonPhrase();
      $status['status-code'] = $resp->getStatusCode();
      $status['body'] = $resp->getBody();
    }
    return $status;
  }
}
