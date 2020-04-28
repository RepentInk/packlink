<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Package;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /***
     * ----------------------------------------------
     * Pages function
     * ----------------------------------------------
     */

     public function indexPage(){
         return view('pages.index');
     }


    public function dashboardPage(){
       return view('pages.dashbored');
    }


    public function searchPackagePage(){
        return view('pages.search');
    }



    //Get Data Function
    public function getPackage(){
        $package = Package::leftJoin('ratings','packages.id','=','ratings.pack_id')
                  ->leftJoin('categories','packages.cat_id','=','categories.id')
                  ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'categories.name as catname','categories.id as catid','packages.description','packages.created_at',
                   DB::raw('count(ratings.pack_id) as totalraters'), DB::raw('sum(ratings.rating) as rate'))
                  ->groupBy('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'packages.description','packages.created_at','catname','catid')
                  ->orderBy('totalraters','desc')
                  ->get();

        return response()->json($package);
    }


    public function getPackageSearch($id){
        $package = Package::leftJoin('categories','packages.cat_id','=','categories.id')
                    ->leftJoin('ratings','ratings.pack_id','=','packages.id')
                    ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                    'packages.description','categories.name as catname','categories.id as catid',
                    'packages.created_at', DB::raw('count(ratings.user_id) as totalraters'), DB::raw('sum(ratings.rating) as rate'))
                    ->groupBy('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                    'packages.description','catname','catid','packages.created_at')
                    ->where('packages.cat_id', $id)
                    ->orderBy('totalraters','desc')
                    ->get();

        return response()->json($package);
    }


    public function getRating($id){
        $rating = Rating::select('rating')->where('pack_id',$id)->get();
        return $rating;
    }

    public function getPackComment($id){
        $comment = Comment::leftJoin('users','comments.user_id','=','users.id')
                   ->select('comments.comment','users.id','users.nickname','comments.created_at','users.profile')
                   ->where('comments.pack_id', $id)
                   ->orderBy('comments.created_at','desc')
                   ->get();

        return response()->json($comment);
    }

    public function getAuthRater($user_id, $pack_id){
        $rated = Rating::where('user_id', $user_id)->where('pack_id', $pack_id)->first();
        if($rated) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getPackageUser(){
        $package = Package::leftJoin('users','packages.user_id','=','users.id')
                  ->leftJoin('categories','packages.cat_id','=','categories.id')
                  ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'packages.description','users.nickname','categories.name as catname','categories.id as catid',
                  'packages.created_at')
                  ->where('packages.user_id', Auth::id())
                  ->orderBy('packages.created_at','desc')
                  ->get();

        return response()->json($package);
    }

    public function getUsers(){
        $users = User::where('deleted_at', null)
                ->select('id','nickname','name','email','profile','location','title','about','created_at')
                ->where('user_type','user')
                ->orderBy('created_at','desc')
                ->get();

        return response()->json($users);
    }



    /**
     * Post request functions
    */
    public function rating(Request $request){
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

    public function comment(Request $request){
        $validator = Validator::make($request->all(), [
            'pack_id' => 'required|numeric',
            'comment' => 'required|string|min:10',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 422);
        }

        try {

            $comment = new Comment();
            $comment->pack_id = $request['pack_id'];
            $comment->user_id = Auth::id();
            $comment->comment = $request['comment'];
            $comment->save();

            return "commented";

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }






}
