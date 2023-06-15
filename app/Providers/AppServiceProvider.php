<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Implements\ProductRepository;
use App\Repositories\Implements\TagRepository;
use App\Repositories\Implements\OrderRepository;
use App\Repositories\Implements\ColorRepository;
use App\Repositories\Implements\SuccessCollectionResponse;
use App\Repositories\Implements\SuccessEntityResponse;

use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ITagRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IColorRepository;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Tag;
use App\Models\Order;
use App\Models\Color;
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
            return new ProductRepository(new Product(),new ProductDetail());
        });
        $this->app->singleton(ITagRepository::class, function () {
            return new TagRepository(new Tag());
        });
        $this->app->singleton(IOrderRepository::class, function () {
            return new OrderRepository(new Order());
        });
        $this->app->singleton(IColorRepository::class, function () {
            return new ColorRepository(new Color());
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
