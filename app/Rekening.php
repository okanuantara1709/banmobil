<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    use SoftDeletes;
    protected $table = 'rekening';
    protected $guarded = [];

    public function satuan_kerja()
    {
        return  $this->belongsTo(SatuanKerja::class);
    }
}
