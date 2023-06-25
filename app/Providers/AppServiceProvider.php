<?php

namespace App\Providers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\ProductResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
