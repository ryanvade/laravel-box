<?php

namespace LaravelBox;

use illuminate\Support\ServiceProvider;

class LaravelBoxServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // configuration files
    $this->publishes([
      __DIR__.'/Config/LaravelBoxConfig.php' => config_path('laravelbox.php'),
    ]);
    }

    public function register()
    {
        // CODE
    }
}
