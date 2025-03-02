<?php

namespace App\Providers;

use App\Repositories\Interfaces\LinkRepositoryInterface;
use App\Repositories\LinkRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        $this->app->bind(LinkRepositoryInterface::class, LinkRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
