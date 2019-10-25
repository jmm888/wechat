<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apigoods extends Model
{
    //
    protected $table = 'apigoods';
    protected $primaryKey = 'goods_id';
    protected $guarded = [];
    public $timestamps = false;
}
