<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponser extends Model
{
    use SoftDeletes;

    protected $table = 'sponsers';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'logo',
    ];

    public function getLogoAttribute($value)
    {
        return asset('/image/sponser/' . $value);
    }
}
