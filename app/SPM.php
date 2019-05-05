<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPM extends Model
{
    use SoftDeletes;
    protected $table = 'spm';
    protected $guarded = [];
}
