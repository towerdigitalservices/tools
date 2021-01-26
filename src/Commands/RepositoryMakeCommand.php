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
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        file_put_contents(app_path("/Repositories/{$model}Repository.php"), $repo);

    }
}