<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TitoRating extends Model
{
    protected $table = 'tito_ratings';

    protected $fillable = [
       'tito_id', 'user_id', 'rating',
    ];

    public static function saveTitoRating($request){

    }

}
