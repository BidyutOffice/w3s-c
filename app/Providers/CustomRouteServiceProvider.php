<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CustomRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::bind('subject', function ($value) {
            return Subject::where('slug', $value)->firstOrFail();
        });

        Route::bind('topic', function ($value) {
            return Topic::where('slug', $value)->firstOrFail();
        });

        Route::bind('content', function ($value) {
            return Content::where('slug', $value)->firstOrFail();
        });
    }
}
