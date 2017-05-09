<?php

namespace LaravelBox;

class ApiResponse
{
    private $statusCode;
    private $message;
    private $contentBody;
    private $contentLocation;
    private $isFile;

    public function isError()
    {
        return $this->statusCode >= 400 && $this->statusCode < 600;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode(integer $code)
    {
        $this->statusCode = $code;
    }

    public function getContentBody()
    {
        return $this->contentBody;
    }

    public function setContentBody(string $content)
    {
        $this->contentBody = $content;
    }

    public function isFile()
    {
        return $this->isFile;
    }

    public function setIsFile(bool $isFile)
    {
        $this->isFile = $isFile;
    }

    public function getFileLocation()
    {
        if ($this->isFile == false) {
            return false;
        }

        return $this->contentLocation;
    }

    public function setFileLocation(string $location)
    {
        $this->contentLocation = $location;
        $this->isFile = true;
    }
}
