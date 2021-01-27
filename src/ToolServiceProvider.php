<?php

namespace Towerdigital\Tools;

use Illuminate\Support\ServiceProvider;
use TowerDigital\Tools\Commands\RepositoryMakeCommand;
use TowerDigital\Tools\Commands\TransformerMakeCommand;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/tools.php' => config_path('tools.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoryGenerator();
        $this->registerTransformerGenerator();
    }

    /**
     * Register the make:repository generator.
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.make.repository', function ($app) {
            return $app->make(RepositoryMakeCommand::class);
        });

        $this->commands('command.make.repository');
    }

    /**
     * Register the make:transformer generator.
     */
    private function registerTransformerGenerator()
    {
        $this->app->singleton('command.make.transformer', function ($app) {
            return $app->make(TransformerMakeCommand::class);
        });

        $this->commands('command.make.transformer');
    }
}