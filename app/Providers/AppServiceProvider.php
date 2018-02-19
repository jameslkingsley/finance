<?php

namespace App\Providers;

use App\Week;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('week', function ($value) {
            return auth()->user()->weeks()
                ->where('ending', Carbon::parse($value))
                ->first();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Route::macro('vue', function ($url, $component) {
            return Route::get($url, function () use ($component) {
                return vue($component);
            });
        });

        require_once app_path('Support/Helpers.php');
    }
}
