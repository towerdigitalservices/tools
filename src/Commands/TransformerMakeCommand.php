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
    protected $signature = 'make:transformer {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer class';

    public function handle()
    {
        if (empty($this->option('model'))) {
            $this->error('You must provide the model option(--model=Example)');
            exit;
        }
        $modelLower = strtolower($this->option('model'));

        $name = $this->argument('name');
        $model = ucfirst($modelLower);
        $stub = file_get_contents(__DIR__ . '/../stubs/Transformer.stub');
        $transformer = str_replace(
            ['{{Model}}', '{{model}}','{{name}}'],
            [$model, $modelLower, $name],
            $stub
        );

        $path = app_path('/Http/Transformers');
        $this->checkForDirectory($path);

        $this->writeToFile($name, $transformer);

    }

    protected function checkForDirectory(string $path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function writeToFile(string $name, string $transformer)
    {
        $name = $this->argument('name');
        if(is_file(app_path("/Http/Transformers/{$name}.php"))) {
            if($this->confirm('This transformer already exists.  Do you want to overwrite it?')) {
                file_put_contents(app_path("/Http/Transformers/{$name}.php"), $transformer);
                $this->info('Transformer overwritten successfully.');
            } else {
                $this->info('Transformer creation aborted.');
            }
        } else {
            file_put_contents(app_path("/Http/Transformers/{$name}.php"), $transformer);
            $this->info('Transformer created successfully.');
        }

    }
}