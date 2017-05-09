<?php

namespace LaravelBox\Factories;

class CommandFactory
{
    public static function createFileCommand()
    {
        if (func_num_args() <= 0) {
            return null;
        }
        $mode = func_get_arg(func_num_args() - 1);
        switch ($mode) {
            case 'move':
                if (fun_num_args() < 4) {
                    return null;
                }
                $token = func_get_arg(0);
                $path = func_get_arg(1);
                $newPath = func_get_arg(2);

                return new MoveFileCommand($token, $path, $newPath);
                break;

            case 'info':
            if (fun_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new GetFileInformationCommand($token, $path);
                break;

                case 'download':
                if (fun_num_args() < 3) {
                    return null;
                }
                $token = func_get_arg(0);
                $path = func_get_arg(1);

                return new DownloadFileCommand($token, $path);
                    break;

            default:
                return null;
                break;
        }
    }
}
