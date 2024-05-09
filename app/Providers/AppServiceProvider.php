<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\PostService\PostService;
use App\Contracts\Services\UserService\UserService;
use App\Contracts\Services\PostService\PostServiceInterface;
use App\Contracts\Services\UserService\UserServiceInterface;

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
        $this->app->bind(
            UserServiceInterface::class, 
            UserService::class
        );

        $this->app->bind(
            PostServiceInterface::class, 
            PostService::class
        );
    }
}
