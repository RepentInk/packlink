<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
       'pack_id', 'user_id', 'rating',
    ];

    public static function saveRating($request){
        $validator = Validator::make($request->all(), [
            'pack_id' => 'required|numeric',
            'rating' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 422);
        }

        try {

            $rating = new Rating();
            $rating->pack_id = $request['pack_id'];
            $rating->user_id = Auth::id();
            $rating->rating = $request['rating'];
            $rating->save();

            return $rating;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public static function getRating($id){
        $rating = Rating::select('rating')
                 ->where('pack_id', $id)
                 ->get();
        return $rating;
    }
}
