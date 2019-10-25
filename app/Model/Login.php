<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    //
    protected $table = 'login';
    protected $primaryKey = 'login_id';
    protected $guarded = [];
    public $timestamps = false;
}
