<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\product;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        product::updated(function($product){
            if($product->quantity == 0 && $product->estaDisponible()){
                $product->status = product::PRODUCTO_NO_DISPONIBLE;
                $product->save();
            }
        });
    }
}
