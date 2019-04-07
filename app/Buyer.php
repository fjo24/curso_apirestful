<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use App\Scopes\BuyerScope;

class Buyer extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}