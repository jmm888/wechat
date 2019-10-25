<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    //
    protected $table = 'good';
    protected $primaryKey = 'good_id';
    protected $guarded = [];
    public $timestamps = false;
}
