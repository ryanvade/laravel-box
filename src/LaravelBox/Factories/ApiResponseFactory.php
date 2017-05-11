<?php

namespace LaravelBox\Factories;

use LaravelBox\ApiResponse;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;

class ApiResponseFactory
{
    public static function build()
    {
        if (func_num_args() < 1) {
            return null;
        }

        $arg = func_get_arg(0);
        if (self::isAnException($arg)) {
            return self::getExceptionResponse($arg);
        }

        if (self::isAResponse($arg)) {
            return self::getResponse($arg);
        }

        return self::getCurlResponse($arg);
    }

    private static function getExceptionResponse($arg)
    {
        $type = get_class($arg);
        $code = $arg->getCode();
        $message = $arg->getMessage();
        $body = $arg->__toString();
        $body_json = json_decode(json_encode(['errors' => $body]));
        $request = $arg->getRequest();
        $response = new ApiResponse($type);
        $response->setCode($code);
        $response->setMessage($message);
        $response->setBody($body);
        $response->setJson($body_json);
        $response->setRequest($request);

        return $response;
    }

    private static function isAnException($arg)
    {
        return ($arg instanceof ClientException) ||
        ($arg instanceof TransferException) ||
        ($arg instanceof RequestException) ||
        ($arg instanceof ServerException);
    }

    private static function getResponse($arg)
    {
        if (self::isFileDownload($arg)) {
            // FILE Download
                $type = 'FILE_DOWNLOAD';
            $code = $arg->getStatusCode();
            $reason = $arg->getReasonPhrase();
            $response = new ApiResponse($type);
            $response->setCode($code);
            $response->setReason($reason);
            $response->setRequest($arg);

            return $response;
        } else {
            $type = 'JSON';
            $code = $arg->getStatusCode();
            $reason = $arg->getReasonPhrase();
            $body = $arg->getBody();
            $body_json = json_decode((string) $body);
            $response = new ApiResponse($type);
            $response->setCode($code);
            $response->setReason($reason);
            $response->setBody($body);
            $response->setJson($body_json);
            $response->setRequest($arg);

            return $response;
        }
    }

    private static function getCurlResponse($arg)
    {
        if ($arg instanceof Exception) {
            $exception = func_get_arg(0);
            $type = 'errors';
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $body = $exception->__toString();
            $body_json = json_decode(json_encode(['errors' => $body]));
            $response = new ApiResponse($type);
            $response->setCode($code);
            $response->setMessage($message);
            $response->setBody($body);
            $response->setJson($body_json);
            $response->setException($exception);

            return $response;
        } else {
            $body = $arg;
            $json = json_decode($arg);
            if (property_exists($json, 'status') && $json->status >= 400) {
                // ERROR Occurred
                $type = $json->type;
                $code = $json->status;
                $message = $json->code;

                $response = new ApiResponse($type);
                $response->setCode($code);
                $response->setMessage($message);
                $response->setJson($json);
                $response->setBody($body);

                return $response;
            } elseif (property_exists($json, 'upload_url')) {
                // PREFLIGHT CHECK
                $type = 'PREFLIGHT_CHECK';
                $code = 200;
                $reason = 'Ok';

                $response = new ApiResponse($type);
                $response->setCode($code);
                $response->setReason($reason);
                $response->setBody($body);
                $response->setJson($json);

                return $response;
            } else {
                // Upload Successful
                $type = 'FILE_UPLOAD';
                $code = 200;
                $reason = 'Ok';
                $fileName = $json->entries[0]->name;

                $response = new ApiResponse($type);
                $response->setCode($code);
                $response->setReason($reason);
                $response->setFileName($fileName);
                $response->setBody($body);
                $response->setJson($json);

                return $response;
            }
        }
    }

    private static function isAResponse($arg)
    {
        return is_a($arg, "GuzzleHttp\Psr7\Response");
    }

    private static function isFileDownload($arg)
    {
        return $arg->hasHeader('Content-Type') && $arg->getHeaderLine('Content-Type') == 'application/octet-stream';
    }

    private static function isJsonDownload($arg)
    {
        return $arg->hasHeader('Content-Type') && $arg->getHeaderLine('Content-Type') == 'application/octet-stream';
    }
}
