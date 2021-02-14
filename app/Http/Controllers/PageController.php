<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Installation;
use App\Language;
use App\Package;
use App\Rating;
use App\TitoRating;
use App\User;
use App\YouTube;
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

    public function searchVideoPage(){
        return view('pages.video');
    }

    public function searchReadPage(){
        return view('pages.read');
    }


    // data without number
    public function getCategory() {
        $category = Category::where('deleted_at', null)
                    ->select('id', 'name')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($category);
    }

    public function getLanguage() {
        $language = Language::where('deleted_at', null)
                    ->select('id', 'name')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($language);
    }

    public function getInstallation() {
        $installation = Installation::where('deleted_at', null)
            ->select('id', 'name')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($installation);
    }



    //Get Data Function
    public function getPackage($number){
        $package = Package::leftJoin('ratings','packages.id','=','ratings.pack_id')
                  ->leftJoin('categories','packages.cat_id','=','categories.id')
                  ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'categories.name as catname','categories.id as catid','packages.description','packages.created_at',
                   DB::raw('count(ratings.pack_id) as totalraters'), DB::raw('sum(ratings.rating) as rate'))
                  ->groupBy('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'packages.description','packages.created_at','categories.name','categories.id')
                  ->orderBy('totalraters','desc')
                  ->paginate($number);

        return response()->json($package);
    }

    public function getPackageSearch($id, $number){
        $package = Package::leftJoin('categories','packages.cat_id','=','categories.id')
                    ->leftJoin('ratings','ratings.pack_id','=','packages.id')
                    ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                    'packages.description','categories.name as catname','categories.id as catid',
                    'packages.created_at', DB::raw('count(ratings.user_id) as totalraters'), DB::raw('sum(ratings.rating) as rate'))
                    ->groupBy('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                    'packages.description','categories.name','categories.id','packages.created_at')
                    ->where('packages.cat_id', $id)
                    ->orderBy('totalraters','desc')
                    ->paginate($number);

        return response()->json($package);
    }

    public function getRating($id){
        $rating = Rating::getRating($id);
        return $rating;
    }

    public function getPackComment($id, $type){
        $comment = Comment::getComments($id, $type);
        return $comment;
    }

    public function getAuthRater($user_id, $pack_id){
        $rated = Rating::where('user_id', $user_id)->where('pack_id', $pack_id)->first();
        if($rated) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getPackageUser($number){
        $package = Package::leftJoin('users','packages.user_id','=','users.id')
                  ->leftJoin('categories','packages.cat_id','=','categories.id')
                  ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'packages.description','users.nickname','categories.name as catname','categories.id as catid',
                  'packages.created_at')
                  ->where('packages.user_id', Auth::id())
                  ->orderBy('packages.created_at','desc')
                  ->paginate($number);

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

    public function getTutorial($number, $type){
        $video_tutorial = YouTube::leftJoin('tito_ratings','you_tubes.id','=','tito_ratings.tito_id')
                  ->leftJoin('languages','you_tubes.lang_id','=','languages.id')
                  ->select('you_tubes.id','you_tubes.name','you_tubes.url','you_tubes.title','you_tubes.type',
                  'languages.name as langname','languages.id as langid','you_tubes.description','you_tubes.created_at',
                   DB::raw('count(tito_ratings.tito_id) as totalraters'), DB::raw('sum(tito_ratings.rating) as rate'))
                  ->groupBy('you_tubes.id','you_tubes.name','you_tubes.url','you_tubes.title','you_tubes.description','you_tubes.created_at',
                  'languages.name','languages.id','you_tubes.type')
                  ->orderBy('totalraters','desc')
                  ->where('you_tubes.type', $type)
                  ->paginate($number);
        return response()->json($video_tutorial);
    }

    public function getSearchTutorial($id, $number, $type){
        $video_tutorial = YouTube::leftJoin('tito_ratings','you_tubes.id','=','tito_ratings.tito_id')
                  ->leftJoin('languages','you_tubes.lang_id','=','languages.id')
                  ->select('you_tubes.id','you_tubes.name','you_tubes.url','you_tubes.title','you_tubes.type',
                  'languages.name as langname','languages.id as langid','you_tubes.description','you_tubes.created_at',
                   DB::raw('count(tito_ratings.tito_id) as totalraters'), DB::raw('sum(tito_ratings.rating) as rate'))
                  ->groupBy('you_tubes.id','you_tubes.name','you_tubes.url','you_tubes.title','you_tubes.description','you_tubes.created_at',
                  'languages.name','languages.id','you_tubes.type')
                  ->orderBy('totalraters','desc')
                  ->where('you_tubes.type', $type)
                  ->where('you_tubes.lang_id', $id)
                  ->paginate($number);

        return response()->json($video_tutorial);
    }

    public function getTitoRating($id, $type){
       $response = TitoRating::getTitoRating($id, $type);
       return response()->json($response);
    }

    public function getAuthTitoRater($user_id, $tito_id, $type){
        $rated = TitoRating::where('user_id', $user_id)->where('tito_id', $tito_id)->where('type', $type)->first();
        if($rated) {
            return '1';
        } else {
            return '0';
        }
    }


    /**
     * Post request functions
    */
    public function rating(Request $request){
        $rating = Rating::saveRating($request);
        return $rating;
    }

    public function comment(Request $request){
        $response = Comment::saveComment($request);
        return $response;
    }

    public function saveTutorial(Request $request){
        $response = TitoRating::saveTitoRating($request);
        return $response;
    }

}
