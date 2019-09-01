<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $timestamps = false;
    protected $table = 'restaurants';
    protected $fillable = ['name','type','owner_id','starts_at','closes_at','district','area','Road_name','Road_no','House_name','House_no','Level','phone'];
}
