<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormBuilder;
use Illuminate\Support\Facades\App;

class FormServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('form', function ($app) {
            return new FormBuilder();
        });
    }

    public function boot(): void
    {
        // Si necesitas hacer algo en el boot
    }

    public function provides(): array
    {
        return ['form'];
    }
}
