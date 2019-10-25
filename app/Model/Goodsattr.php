<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goodsattr extends Model
{
    //
    protected $table = 'goodsattr';
    protected $primaryKey = 'goodsattr_id';
    protected $guarded = [];
    public $timestamps = false;
}
