<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
       'user_id', 'pack_id', 'comment',
    ];

    public static function saveComment($request){
        $validator = Validator::make($request->all(), [
            'pack_id' => 'required|numeric',
            'comment' => 'required|string|min:10',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 422);
        }

        try {

            $comment = new Comment();
            $comment->user_id = Auth::id();
            $comment->pack_id = $request['pack_id'];
            $comment->type = $request['type'];
            $comment->comment = $request['comment'];
            $comment->save();

            return "commented";

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public static function getComments($id, $type){
        $comment = Comment::leftJoin('users','comments.user_id','=','users.id')
        ->select('comments.comment','users.id','users.nickname','comments.created_at','users.profile')
        ->where('comments.pack_id', $id)
        ->where('comments.type', $type)
        ->orderBy('comments.created_at','desc')
        ->get();
       return response()->json($comment);
    }

}
