<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Rest_Food extends Model
{
    
    public $timestamps = false;
    protected $table = 'order__rest__foods';
    protected $fillable = ['order_id','restaurantfood_id','amount'];
}
