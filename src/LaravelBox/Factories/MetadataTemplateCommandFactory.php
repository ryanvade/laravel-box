<?php

namespace LaravelBox\Factories;

use LaravelBox\Commands\Metadata\CreateMetadataTemplateCommand;
use LaravelBox\Commands\Metadata\GetEnterpriseMetadataTemplates;

class MetadataTemplateCommandFactory
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
                $template = func_get_arg(1);
                return new CreateMetadataTemplateCommand($token, $template);
                break;
            case 'list':
                $token = func_get_arg(0);
                return new GetEnterpriseMetadataTemplates($token);
                break;

            default:
                return null;
        }
    }
}
