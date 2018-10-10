<?php

namespace LaravelBox\Factories;

use LaravelBox\Commands\Metadata\CreateMetadataOnFileCommand;
use LaravelBox\Commands\Metadata\UpdateMetadataOnFileCommand;
use LaravelBox\Commands\Metadata\GetMetadataOnFileCommand;
use LaravelBox\Commands\Metadata\DeleteMetadataOnFileCommand;
use LaravelBox\Commands\Metadata\GetEnterpriseMetadataTemplates;

class MetadataFileCommandFactory
{
    public static function build()
    {
        if (func_num_args() < 1) {
            return null;
        }

        $command = func_get_arg(func_num_args() - 1);
        switch ($command) {
            case 'create':
                $token = func_get_arg(0);
                $fileId = func_get_arg(1);
                $templateKey = func_get_arg(2);
                $metadata = func_get_arg(3);
                return new CreateMetadataOnFileCommand($token, $fileId, $templateKey, $metadata);
                break;

            case 'update':
                $token = func_get_arg(0);
                $fileId = func_get_arg(1);
                $templateKey = func_get_arg(2);
                $metadata = func_get_arg(3);
                return new UpdateMetadataOnFileCommand($token, $fileId, $templateKey, $metadata);
                break;

            case 'get':
                $token = func_get_arg(0);
                $fileId = func_get_arg(1);
                $templateKey = func_get_arg(2);
                return new GetMetadataOnFileCommand($token, $fileId, $templateKey);
                break;

            case 'delete':
                $token = func_get_arg(0);
                $fileId = func_get_arg(1);
                $templateKey = func_get_arg(2);
                return new DeleteMetadataOnFileCommand($token, $fileId, $templateKey);
                break;

            default:
                return null;
        }
    }
}
