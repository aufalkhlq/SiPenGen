<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::info('SQL Query Executed', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time
            ]);
        });
    }
}
