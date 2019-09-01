<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    public $timestamps = false;
    protected $table = 'food_items';
    protected $fillable = ['name','type'];
}
