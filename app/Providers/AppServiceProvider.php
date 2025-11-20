<?php

namespace App\Providers;

use App\Contracts\JobServiceInterface;
use App\Models\Category;
use App\Services\JobService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //this basically tells the container that when a class needs an implementation of
        //this interface bind/inject the JobService container
        $this->app->bind(JobServiceInterface::class, JobService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
