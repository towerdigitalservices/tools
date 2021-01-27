<?php

namespace TowerDigital\Tools\Commands;

use Illuminate\Console\Command;

class RepositoryMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    public function handle()
    {
        $modelLower = strtolower($this->option('model'));
        $model = ucfirst($modelLower);
        $stub = file_get_contents(__DIR__ . '/../stubs/Repository.stub');
        $repo = str_replace(
            ['{{Model}}'],
            [$model],
            $stub
        );
        $repo = str_replace(
            ['{{model}}'],
            [$modelLower],
            $repo
        );
        $path = app_path('/Repositories');
        $this->checkForDirectory($path);
        $this->writeToFile($model, $repo);

    }

    protected function checkForDirectory(string $path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function writeToFile(string $model, string $repo)
    {
        if(is_file(app_path("/Repositories/{$model}Repository.php"))) {
            if($this->confirm('This file already exists.  Do you want to overwrite it?')) {
                file_put_contents(app_path("/Repositories/{$model}Repository.php"), $repo);
            } else {
                $this->info('Repository creation aborted.');
            }
        } else {
            file_put_contents(app_path("/Repositories/{$model}Repository.php"), $repo);
            $this->info('Repository created successfully.');
        }
    }
}