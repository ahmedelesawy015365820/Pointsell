<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = ['name', 'phone', 'address'];

    public function order()
    {
        return $this->hasMany('App\Order','client_id','id');
    }

}
