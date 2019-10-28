<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BahanBakuBarang extends Model
{
    protected $table = 'bahan_baku_barang';
    protected $guarded = [];

    function produksi(){
        return $this->belongsTo('App\Produksi');
    }

    function bahanBaku(){
        return $this->belongsTo('App\BahanBaku');
    }
}
