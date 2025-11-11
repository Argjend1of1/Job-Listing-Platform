<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Model::unguard();

//        !!Commented out because we have no view only JSX through React!!
        View::composer('*', function($view) {
            $view->with('navbarCategories', Category::all());
        });

//        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
