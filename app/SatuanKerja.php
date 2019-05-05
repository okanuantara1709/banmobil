<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    use SoftDeletes;
    protected $table = 'satker';
    protected $guarded = [];
}
