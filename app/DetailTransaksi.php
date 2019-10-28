<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
   protected $guarded = [];

    function barang(){
        return $this->belongsTo('App\Barang');
    }
}
