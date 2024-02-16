<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Config\ConfigurationInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Core\Interfaces\File\CsvReaderInterface::class, \Modules\Sheet\CsvReader::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
