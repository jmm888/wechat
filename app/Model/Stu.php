<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stu extends Model
{
    //
    protected $table = 'stu';
    protected $primaryKey = 'stu_id';
    protected $guarded = [];
    public $timestamps = false;
}
