<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\OrderProduct;
use App\Models\Shop;
use App\Models\User;

class Order extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'shop_id',
        'user_id',
        'total_cost_price',
        'total_sell_price',
        'status',
    ];

  


    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
