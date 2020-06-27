<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YouTube extends Model
{
    use SoftDeletes;

    protected $table = 'you_tubes';

    protected $dates = [
        'deleted_at'
    ];
}
