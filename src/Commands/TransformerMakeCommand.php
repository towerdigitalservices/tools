<?php

namespace TowerDigital\Tools\Commands;

use Illuminate\Console\Command;

class TransformerMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:transformer {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer class';

    public function handle()
    {
        $modelLower = strtolower($this->option('model'));
        $model = ucfirst($modelLower);
        $stub = file_get_contents(__DIR__ . '/../stubs/Transformer.stub');
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
        $path = app_path('/Transformers');
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        file_put_contents(app_path("/Transformers/{$model}Transformer.php"), $repo);

    }
}