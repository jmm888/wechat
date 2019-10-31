<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    //
    protected $table = 'wechat';
    protected $primaryKey = 'user_id';
    protected $guarded = [];
    public $timestamps = false;
}
