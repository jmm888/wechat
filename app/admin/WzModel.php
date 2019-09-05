<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class WzModel extends Model
{
    protected $primaryKey = 'wz_id';
    protected $table='wz';
    public $timestamps = false;
}
