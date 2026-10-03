<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Symfony\Component\Process\PhpExecutableFinder;

class ServeCommand extends BaseServeCommand
{
    /**
     * Get the full server command.
     *
     * @return array
     */
    protected function serverCommand()
    {
        $server = file_exists(base_path('server.php'))
            ? base_path('server.php')
            : base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php');

        return [
            (new PhpExecutableFinder)->find(false) ?: 'php',
            '-d',
            'upload_max_filesize=25M',
            '-d',
            'post_max_size=30M',
            '-S',
            $this->host() . ':' . $this->port(),
            $server,
        ];
    }
}
