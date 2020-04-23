<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $table = 'packages';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
       'name', 'link', 'command', 'description', 'procedure', 'cat_id', 'user_id',
    ];
}
