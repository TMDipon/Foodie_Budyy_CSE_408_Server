<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant_FoodItem extends Model
{
    public $timestamps = false;
    protected $table = 'restaurant__food_items';
    protected $fillable = ['restaurant_id','foodItem_id','description','unit_price'];
}
