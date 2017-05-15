<?php

namespace LaravelBox;

class ApiResponse
{
    private $type = null;
    private $code = null;
    private $message = null;
    private $body = null;
    private $json = null;
    private $request = null;
    private $reason = null;
    private $exception = null;
    private $fileName = null;
    private $stream = null;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isError()
    {
        return ($this->type == 'errors') || ($this->code > 399) || ($this->exception != null);
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setJson($json)
    {
        $this->json = $json;
    }

    public function getJson()
    {
        return $this->json;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setException($exception)
    {
        $this->exception = $exception;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    public function toArray()
    {
        $arr = array();
        $arr['code'] = $this->code;
        $arr['body'] = $this->body;
        $arr['json'] = $this->json;
        if ($this->stream != null) {
            $arr['stream'] = $this->stream;
        }

        return $arr;
    }
}
