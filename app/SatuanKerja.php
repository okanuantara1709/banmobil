<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanKerja extends Model
{
    use SoftDeletes;
    protected $table = 'satker';
    protected $guarded = [];
}
