<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SPM extends Model
{
    protected $table = 'spm';
    protected $guarded = [];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }
}
