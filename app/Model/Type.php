<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $table = 'type';
    protected $primaryKey = 'type_id';
    protected $guarded = [];
    public $timestamps = false;
}
