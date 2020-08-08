<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usage extends Model
{
    use SoftDeletes;

    protected $table = 'usages';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
       'pack_id', 'lang_id',
    ];

}
