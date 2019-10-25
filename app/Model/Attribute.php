<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $primaryKey = 'attr_id';
    protected $guarded = [];
    public $timestamps = false;
}
