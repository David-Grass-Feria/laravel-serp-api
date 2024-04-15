<?php

namespace GrassFeria\LaravelSerpApi\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use GrassFeria\LaravelSerpApi\Console\Commands\InstallLaravelSerpApiCommand;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laravel-serp-api.php', 'laravel-serp-api'
        );
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
       
        //
        

    }
}