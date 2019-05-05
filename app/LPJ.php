<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LPJ extends Model
{
    use SoftDeletes;
    protected $table = 'lpj';
    protected $guarded = [];
}
