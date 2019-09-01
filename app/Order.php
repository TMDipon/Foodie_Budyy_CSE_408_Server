<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'orders';
    protected $fillable = ['user_id','restaurant_id','user_lati','user_longi','restaurant_lati','restaurant_longi','order_status','rider_status','rider_id'];
}
