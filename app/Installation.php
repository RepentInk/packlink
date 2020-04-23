<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use SoftDeletes;

    protected $table = 'installations';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = ['name'];
}
