<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Symfony\Component\Process\PhpExecutableFinder;

class CustomServeCommand extends BaseServeCommand
{
    protected $name = 'serve';
    protected $description = 'Serve the application (Windows-fixed version)';

    protected function serverCommand()
    {
        $server = file_exists(base_path('server.php'))
            ? base_path('server.php')
            : __DIR__.'/../../../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php';

        return [
            (new PhpExecutableFinder)->find(false) ?: 'php',
            '-S',
            $this->host().':'.$this->port(),
            $server,
        ];
    }

    protected function startProcess($hasEnvironment)
    {
        $command = $this->serverCommand();
        
        // For Windows, use a simpler approach
        $host = $this->host();
        $port = $this->port();
        
        $this->components->info("Server running on [http://{$host}:{$port}].");
        $this->comment('  <fg=yellow;options=bold>Press Ctrl+C to stop the server</>');
        $this->newLine();

        // Change to public directory and run
        chdir(public_path());
        
        // Execute directly without Symfony Process
        passthru(implode(' ', array_map('escapeshellarg', $command)));
        
        exit(0);
    }
}
