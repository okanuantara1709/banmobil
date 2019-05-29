<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = [];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }
}
