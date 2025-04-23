<?php

namespace App\Providers;

use App\Models\Categories;
use App\Repositories\CategoryRepositori;
use App\Repositories\Contracts\CategoryRepositoriInterface;
use App\Repositories\Contracts\OrderRepositoriInterface;
use App\Repositories\Contracts\ProductRepositoriInterface;
use App\Repositories\Contracts\PromoCodeRepositoriInterface;
use App\Repositories\OrderRepositori;
use App\Repositories\ProductRepositori;
use App\Repositories\PromoCodeRepositori;
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
        $this->app->singleton(CategoryRepositoriInterface::class, CategoryRepositori::class);

        $this->app->singleton(OrderRepositoriInterface::class, OrderRepositori::class);

        $this->app->singleton(ProductRepositoriInterface::class, ProductRepositori::class);

        $this->app->singleton(PromoCodeRepositoriInterface::class, PromoCodeRepositori::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories', Categories::all());
        });
    }
}
