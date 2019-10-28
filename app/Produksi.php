<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi';
    protected $guarded = [];

    function barang(){
        return $this->belongsTo('App\Barang');
    }
}
