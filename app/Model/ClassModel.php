<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    //
    protected $table = 'class';
    protected $primaryKey = 'class_id';
    protected $guarded = [];
    public $timestamps = false;
}
