<?php

namespace App\Http\Controllers;

use App\Category;
use App\Installation;
use App\Language;
use App\Medium;
use App\Package;
use App\Rating;
use App\Usage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * View Page
    */
    public function indexPage(){
        return view('admin.index');
    }

    public function userPage(){
        return view('admin.user');
    }

    public function categoryPage(){
        return view('admin.category');
    }

    public function languagePage(){
        return view('admin.language');
    }

    public function installationPage(){
        return view('admin.installation');
    }

    public function packagePage(){
        return view('admin.package');
    }



    /**
     * Get Data
    */
    public function getUsers(){
        $users = User::where('deleted_at', null)->select('id','nickname','name','email','user_type','profile','location','title',
        'about','created_at')->orderBy('created_at','desc')->get();

        return response()->json($users);
    }


    public function getCategory(){
        $category = Category::where('deleted_at', null)
                ->select('id','name','created_at')
                ->orderBy('created_at','desc')
                ->get();
        return response()->json($category);
    }

    public function getLanguage(){
        $language = Language::where('deleted_at', null)
                ->select('id','name','created_at')
                ->orderBy('created_at','desc')
                ->get();
        return response()->json($language);
    }

    public function getInstallation(){
        $installation = Installation::where('deleted_at', null)
                ->select('id','name','created_at')
                ->orderBy('created_at','desc')
                ->get();
        return response()->json($installation);
    }

    public function getPackage(){
        $package = Package::leftJoin('users','packages.user_id','=','users.id')
                  ->leftJoin('categories','packages.cat_id','=','categories.id')
                  ->select('packages.id','packages.name','packages.link','packages.command','packages.procedure',
                  'packages.description','users.nickname','categories.name as catname','categories.id as catid',
                  'packages.created_at')
                  ->orderBy('packages.created_at','desc')
                  ->get();

        return response()->json($package);
    }




    /**
     * Save Data
    */
    public function saveUser(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'email|unique:users,email|nullable',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $user = new User();
            $user->nickname = $request['name'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->user_type = "admin";
            $user->password = bcrypt($request['password']);

            if($request->hasFile('profile')){
                $picture  = $request->file('profile');
                $filename = time().$picture->getClientOriginalName();
                Image::make($picture)->save( public_path('image/user/' . $filename));
                $user->profile = $filename;
            } else {
                $user->profile = 'avatar.png';
            }

            $user->save();

            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function saveCategory(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        try{

            $name = strtolower($request['name']);
            Category::firstOrCreate(['name' => $name]);
            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function saveLanguage(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        try{

            Language::firstOrCreate(['name' => strtolower($request['name'])]);
            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function saveInstallation(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        try{

            Installation::firstOrCreate(['name' => strtolower($request['name'])]);
            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function savePackage(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'link' => 'required|url',
            'command' => 'required|string',
            'cat_id' => 'required|numeric',
            'procedure' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()],422);
        }

        try{

            $existLink = Package::where('link', $request['link'])->where('deleted_at',null)->first();
            if($existLink) {
                return response()->json(['error' => "A Package has been registered with the link provided"], 402);
            }

            $package = new Package();
            $package->link = $request['link'];
            $package->name = $request['name'];
            $package->command = $request['command'];
            $package->cat_id = $request['cat_id'];
            $package->user_id = Auth::id();
            $package->description = $request['description'];
            $package->procedure = $request['procedure'];
            $package->save();

            if ($request['install_id']){
                foreach ($request['install_id'] as $install){
                    $medium = new Medium();
                    $medium->pack_id = $package->id;
                    $medium->install_id = $install;
                    $medium->save();
                }
            }

            if ($request['lang_id']){
                foreach ($request['lang_id'] as $lang){
                    $usage = new Usage();
                    $usage->pack_id = $package->id;
                    $usage->lang_id = $lang;
                    $usage->save();
                }
            }

            return "saved";

        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],402);
        }
    }




    /**
     * Update data functions
     *
    */
    public function updateUser(Request $request){

        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'nickname' => 'required|string',
            'name' => 'required|string|min:2',
            'email' =>  'email|required|sometimes',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $id = $request['id'];
            $user = User::findOrFail($id);
            $user->nickname = $request['nickname'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->location = $request['location'];
            $user->title = $request['title'];
            $user->about = $request['about'];

            if($request->hasFile('profile')){
                $picture  = $request->file('profile');
                $filename = time().$picture->getClientOriginalName();
                Image::make($picture)->save( public_path('image/user/' . $filename));
                $user->profile = $filename;
            }


            $user->update();

            return 'updated';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function updatePassword(Request $request){
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()],422);
        }


        try {

            $id = $request['id'];
            $user = User::findOrFail($id);
            $user->password = bcrypt($request['password']);
            $user->update();

            return "password updated";

        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],401);
        }

    }

    public function updateCategory(Request $request){

        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $id = $request['id'];
            $category = Category::findOrFail($id);
            $category->name = strtolower($request['name']);
            $category->save();

            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function updateLanguage(Request $request){

        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $id = $request['id'];
            $language = Language::findOrFail($id);
            $language->name = strtolower($request['name']);
            $language->save();

            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function updateInstallation(Request $request){

        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|min:2',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $id = $request['id'];
            $installation = Installation::findOrFail($id);
            $installation->name = strtolower($request['name']);
            $installation->save();

            return 'created';

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function updatePackage(Request $request){
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|min:2',
            'link' => 'required|string|min:2',
            'command' => 'required|string',
            'cat_id' => 'required|numeric',
            'procedure' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()],422);
        }

        try{

            $id = $request['id'];
            $package = Package::findOrFail($id);
            $package->link = $request['link'];
            $package->name = $request['name'];
            $package->command = $request['command'];
            $package->cat_id = $request['cat_id'];
            $package->description = $request['description'];
            $package->procedure = $request['procedure'];
            $package->update();

            if ($request['install_id']){
                foreach ($request['install_id'] as $install){

                    $exist = Medium::where('pack_id',$id)->where('install_id', $install)->first();

                    if(!$exist) {
                        $medium = new Medium();
                        $medium->pack_id = $package->id;
                        $medium->install_id = $install;
                        $medium->save();
                    }


                }
            }

            if ($request['lang_id']){
                foreach ($request['lang_id'] as $lang){

                    $exist = Usage::where('pack_id',$id)->where('lang_id', $lang)->first();

                    if(!$exist) {
                        $usage = new Usage();
                        $usage->pack_id = $package->id;
                        $usage->lang_id = $lang;
                        $usage->save();
                    }
                }
            }

            return "saved";

        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],402);
        }
    }


    /**
     * Get with id
    */
    public function getPackLang($id){
        $lang = Usage::leftJoin('languages','usages.lang_id','=','languages.id')
                ->select('languages.id','languages.name')
                ->where('usages.pack_id',$id)
                ->get();

        return response()->json($lang);
    }

    public function getPackInstall($id){
        $install = Medium::leftJoin('installations','media.install_id','=','installations.id')
                    ->select('installations.id','installations.name')
                    ->where('media.pack_id',$id)
                    ->get();

        return response()->json($install);
    }


    /**
     * Delete data
    */
    public function deleteUser($id){
         $user = User::findOrFail($id);
         $user->delete();
        return "deleted";
    }

    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();
       return "deleted";
    }

    public function deleteLanguage($id){
        $language = Language::findOrFail($id);
        $language->delete();
       return "deleted";
    }

    public function deleteInstallation($id){
        $installation = Installation::findOrFail($id);
        $installation->delete();
       return "deleted";
    }

    public function deletePackage($id){
        Medium::where('pack_id', $id)->delete();
        Usage::where('pack_id', $id)->delete();
        Package::where('id', $id)->delete();
    }

    public function deletePackLang($id){
       Usage::where('lang_id', $id)->forceDelete();
       return "deleted";
    }

    public function deletePackInstall($id){
       Medium::where('install_id', $id)->forceDelete();
       return "deleted";
    }

}
