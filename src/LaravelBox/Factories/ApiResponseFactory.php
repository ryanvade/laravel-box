<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;

namespace LaravelBox\Factories;

class ApiResponseFactory
{
    public static function build()
    {
        if (func_num_args() < 1) {
            return null;
        }
        if ((func_get_arg(0) instanceof ClientException) || (func_get_arg(0) instanceof TransferException) || (func_get_arg(0) instanceof RequestException) || (func_get_arg(0) instanceof ServerException)) {
            // Errors
            $exception = func_get_arg(0);
            $type = 'errors';
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $body = $exception->__toString();
            $body_json = json_decode(json_encode(['errors' => $body]));
            $request = $exception->getRequest();

            $response = new ApiResponse($type);
            $response->setCode($code);
            $response->setMessage($message);
            $response->setBody($body);
            $response->setJson($json);
            $response->setRequest($request);
        } elseif (func_get_arg(0) instanceof Response) {
            // GuzzleHttp Request
            $request = fun_get_arg(0);
            if ($request->hasHeader('Content-Type') && $request->getHeaderLine('Content-Type') == 'application/octet-stream') {
                // FILE Download
                $type = 'FILE_DOWNLOAD';
                $code = $request->getStatusCode();
                $reason = $request->getReasonPhrase();
                $fileName = func_get_arg(1); // passed in separately

                $response = new ApiResponse($type);
                $response->setCode($code);
                $response->setReason($reason);
                $response->setFileName($fileName);
                $response->setRequest($request);
            } elseif ($request->hasHeader('Content-Type') && $request->getHeaderLine('Content-Type') == 'application/octet-stream') {
                $type = 'JSON';
                $code = $request->getStatusCode();
                $reason = $request->getReasonPhrase();
                $body = $request->getBody();
                $body_json = json_decode((string) $body);

                $response = new ApiResponse($type);
                $response->setCode($code);
                $response->setReason($reason);
                $response->setBody($body);
                $response->setJson($body_json);
                $response->setRequest($request);
            }
        } else {
            // cURL Response
            if (func_get_arg(0) instanceof Exception) {
                // Generic Exception thrown by cURL
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
            } else {
                $body = func_get_arg(0);
                $body_json = json_encode($body);

                if (property_exists($body_json, 'status') && $body_json->status >= 400) {
                    // Error given
                    $type = $body_json->type;
                    $message = $body_json->message;
                    $code = $body_json->status;
                    $reason = $body_json->code;

                    $response = new ApiResponse($type);
                    $response->setBody($body);
                    $response->setJson($body_json);
                    $response->setCode($code);
                    $response->setMessage($message);
                    $response->setReason($reason);
                } else {
                    $type = 'FILE_UPLOAD';
                    $code = 200;
                    $reason = $body_json->entries[0]->item_status;
                    $fileName = $body_json->entries[0]->name;

                    $response = new ApiResponse($type);
                    $response->setBody($body);
                    $response->setJson($body_json);
                    $response->setCode($code);
                    $response->setReason($reason);
                    $response->setFileName($fileName);
                }
            }
        }

        return $response;
    }
}
