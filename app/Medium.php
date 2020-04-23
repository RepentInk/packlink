<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medium extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
       'pack_id', 'install_id',
    ];
}
