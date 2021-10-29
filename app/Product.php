<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'purchase_price',
        'sale_price',
        'stock',
        'category_id'
    ];

    public function category()
    {

        return $this->belongsTo('App\Category','category_id');

    }

    public function orders()
    {

        return $this->belongsToMany('App\Order','product_order','product_id','order_id')->withPivot('amount');;

    }

}
