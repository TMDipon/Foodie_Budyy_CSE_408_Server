<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public $timestamps = false;
    protected $table = 'owners';
    protected $fillable = ['name','email_id','password'];
}
