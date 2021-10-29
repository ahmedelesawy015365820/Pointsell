<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [ 'client_id','price'];

    public function clients()
    {
        return $this->belongsTo('App\Client','client_id','id');
    }

    public function products()
    {

        return $this->belongsToMany('App\Product','product_order','order_id','product_id')->withPivot('amount');

    }

}
