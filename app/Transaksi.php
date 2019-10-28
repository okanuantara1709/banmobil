<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = [];

    function pelanggan(){
        return $this->belongsTo('App\Pelanggan');
    }
}
