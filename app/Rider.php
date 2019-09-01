<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    public $timestamps = false;
    protected $table = 'riders';
    protected $fillable = ['name','email_id','phone','NID','district','area','password'];
}
