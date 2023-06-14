<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Implements\ProductRepository;
use App\Repositories\Implements\SuccessCollectionResponse;
use App\Repositories\Implements\SuccessEntityResponse;

use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use App\Models\Product;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IProductRepository::class, function () {
            return new ProductRepository(new Product());
        });
        $this->app->singleton(ISuccessCollectionResponse::class,SuccessCollectionResponse::class);
        $this->app->singleton(ISuccessEntityResponse::class,SuccessEntityResponse::class);
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
