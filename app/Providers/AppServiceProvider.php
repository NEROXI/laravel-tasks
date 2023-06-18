<?php

namespace App\Providers;

use App\Services\ImageService;
use App\Services\ReviewService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageService::class, function () {return new ImageService();});
        $this->app->bind(ReviewService::class, function () {return new ReviewService();});
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
