<?php

namespace RomaMb\Press;

use Illuminate\Support\ServiceProvider;
use RomaMb\Press\Console\ProcessCommand;
use RomaMb\Press\Fields\Body;
use RomaMb\Press\Fields\Date;
use RomaMb\Press\Fields\Description;
use RomaMb\Press\Fields\Extra;
use RomaMb\Press\Fields\Title;

class PressBaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerFacades();
        $this->registerResources();
        $this->registerFields();
    }

    /** @inheritDoc */
    public function register(): void
    {
        $this->commands([
            ProcessCommand::class,
        ]);
    }

    private function registerResources(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'press');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/press.php' => config_path('press.php'),
        ], 'press-config');

        $this->publishes([
            __DIR__ . '/Console/stubs/PressServiceProvider.stub' => app_path('Providers/PressServiceProvider.php'),
        ], 'press-service-provider');
    }

    protected function registerFacades(): void
    {
        $this->app->singleton('Press', static function ($app) {
            return new \RomaMb\Press\Press();
        });
    }

    private function registerFields(): void
    {
        \RomaMb\Press\Facades\Press::mergeFields([
            'Body' => Body::class,
            'Date' => Date::class,
            'Description' => Description::class,
            'Extra' => Extra::class,
            'Title' => Title::class,
        ]);
    }
}
