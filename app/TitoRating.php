<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TitoRating extends Model
{
    protected $table = 'tito_ratings';

    protected $fillable = [
       'tito_id', 'user_id', 'rating',
    ];

    public static function saveTitoRating($request){
        $validator = Validator::make($request->all(), [
            'tito_id' => 'required|numeric',
            'rating' => 'required|numeric',
            'type' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 422);
        }

        try {

            $rating = new TitoRating();
            $rating->tito_id = $request['tito_id'];
            $rating->user_id = Auth::id();
            $rating->type = $request['type'];
            $rating->rating = $request['rating'];
            $rating->save();

            return $rating;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public static function getTitoRating($id, $type){
        $rating = TitoRating::select('rating')
                 ->where('tito_id', $id)
                 ->where('type', $type)
                 ->get();
        return $rating;
    }


}
