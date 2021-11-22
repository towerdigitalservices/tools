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
    protected $signature = 'make:repository {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    public function handle()
    {
        if (empty($this->option('model'))) {
            $this->error('You must provide the model option(--model=Example)');
            exit;
        }
        $name = $this->argument('name');
        $modelLower = strtolower($this->option('model'));
        $model = ucfirst($modelLower);
        $stub = file_get_contents(__DIR__ . '/../stubs/Repository.stub');
        $repo = str_replace(
            ['{{Model}}', '{{model}}','{{name}}'],
            [$model, $modelLower, $name],
            $stub
        );

        $path = app_path('/Repositories');
        $this->checkForDirectory($path);

        $name = $this->argument('name');
        $this->writeToFile($name, $repo);

    }

    protected function checkForDirectory(string $path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function writeToFile(string $name, string $repo)
    {
        if(is_file(app_path("/Repositories/{$name}.php"))) {
            if($this->confirm('This file already exists.  Do you want to overwrite it?')) {
                file_put_contents(app_path("/Repositories/{$name}.php"), $repo);
                $this->info('Repository overwritten successfully.');
            } else {
                $this->info('Repository creation aborted.');
            }
        } else {
            file_put_contents(app_path("/Repositories/{$name}.php"), $repo);
            $this->info('Repository created successfully.');
        }
    }
}