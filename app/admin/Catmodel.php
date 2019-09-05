<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Catmodel extends Model
{
    protected $primaryKey = 'cat_id';
    protected $table='cat';
    public $timestamps = false;
}
