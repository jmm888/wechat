<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'test_id';
    protected $guarded = [];
    public $timestamps = false;
}
