<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $primaryKey = 'stu_id';
    protected $table='student';
    public $timestamps = false;

}
