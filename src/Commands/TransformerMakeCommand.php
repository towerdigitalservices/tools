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
        $transformer = str_replace(
            ['{{Model}}'],
            [$model],
            $stub
        );
        $transformer = str_replace(
            ['{{model}}'],
            [$modelLower],
            $transformer
        );
        $path = app_path('/Transformers');
        $this->checkForDirectory($path);
        $this->writeToFile($model, $transformer);

    }

    protected function checkForDirectory(string $path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function writeToFile(string $model, string $transformer)
    {
        if(is_file(app_path("/Transformers/{$model}Transformer.php"))) {
            if($this->confirm('This transformer already exists.  Do you want to overwrite it?')) {
                file_put_contents(app_path("/Transformers/{$model}Transformer.php"), $transformer);
                $this->info('Transformer overwritten successfully.');
            } else {
                $this->info('Transformer creation aborted.');
            }
        } else {
            file_put_contents(app_path("/Transformers/{$model}Transformer.php"), $transformer);
            $this->info('Transformer created successfully.');
        }
    }
}