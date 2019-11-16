<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiBeli extends Model
{
    protected $table = 'detail_transaksi_beli';
    protected $guarded = [];

    function bahanBaku(){
        return $this->belongsTo('App\BahanBaku');
    }
}
