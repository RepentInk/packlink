<?php

use Illuminate\Support\Facades\Route;



/**
 * Front end route
*/
Route::get('/','PageController@indexPage')->name('index');


/***
 * All Guest route goes below
*/
Route::group(['middleware' => ['guest']], function () {

    /***
     * Get Routes Goes below
    */
    Route::get('/signup','LoginController@signupPage')->name('signup');
    Route::get('/sign-in/github','LoginController@github');
    Route::get('/sign-in/github/redirect','LoginController@githubRedirect');
    Route::get('/sign-in/google','LoginController@google');
    Route::get('/sign-in/google/redirect','LoginController@googleRedirect');
    Route::get('/logout','LoginController@logout')->name('logout');
    Route::get('/search/package','PageController@searchPackagePage')->name('search.package');


    // Get Data
    Route::get('/category','AdminController@getCategory');
    Route::get('/package','PageController@getPackage');


    // Data with id
    Route::get('/pack/search/{id}','PageController@getPackageSearch');
    Route::get('/pack/lang/{id}', 'AdminController@getPackLang');
    Route::get('/pack/install/{id}', 'AdminController@getPackInstall');
    Route::get('/rating/{id}', 'PageController@getRating');
    Route::get('/comment/{id}', 'PageController@getPackComment');


    /**
     * Post Routes Goes Here
    */
    Route::post('/signup', 'LoginController@saveUser');
    Route::post('/login', 'LoginController@loginUser');

});




/***
 * All Auth:User route goes below
*/

Route::group(['middleware' => ['auth', 'user']], function () {

    /**
     * Get Route
    */
    Route::get('/dashboard','PageController@dashboardPage')->name('dashboard');
    Route::get('/logout','LoginController@logout')->name('logout');


    //Get Data Routes
    Route::get('/get/category','AdminController@getCategory');
    Route::get('/get/package','PageController@getPackage');
    Route::get('/get/user/package','PageController@getPackageUser');
    Route::get('/get/category','AdminController@getCategory');
    Route::get('/get/language','AdminController@getLanguage');
    Route::get('/get/installation','AdminController@getInstallation');
    Route::get('/get/users','PageController@getUsers');


    //Get Data with ID
    Route::get('/get/pack/search/{id}','PageController@getPackageSearch');
    Route::get('/get/pack/lang/{id}', 'AdminController@getPackLang');
    Route::get('/get/pack/install/{id}', 'AdminController@getPackInstall');
    Route::get('/get/rating/{id}', 'PageController@getRating');
    Route::get('/get/comment/{id}', 'PageController@getPackComment');
    Route::get('/get/auth/rater/{user_id}/{pack_id}', 'PageController@getAuthRater');


    //Post Routes
    Route::post('/post/rating', 'PageController@rating');
    Route::post('/post/comment', 'PageController@comment');
    Route::post('/post/package','AdminController@savePackage');
    Route::post('/post/category','AdminController@saveCategory');
    Route::post('/post/installation','AdminController@saveInstallation');
    Route::post('/post/language','AdminController@saveLanguage');

    //Update Routes
    Route::post('/update/profile', 'AdminController@updateUser');
    Route::post('/update/package', 'AdminController@updatePackage');
    Route::post('/change/password', 'AdminController@updatePassword');

    //Delete Routes
    Route::delete('/delete/package/{id}', 'AdminController@deletePackage');
    Route::delete('/delete/pack/lang/{id}', 'AdminController@deletePackLang');
    Route::delete('/delete/pack/install/{id}', 'AdminController@deletePackInstall');

});






Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::prefix('/admin')->group(function (){

        //pages route
        Route::get('/index','AdminController@indexPage')->name('admin.index');
        Route::get('/user','AdminController@userPage')->name('admin.user');
        Route::get('/category','AdminController@categoryPage')->name('admin.category');
        Route::get('/language','AdminController@languagePage')->name('admin.language');
        Route::get('/installation','AdminController@installationPage')->name('admin.installation');
        Route::get('/package','AdminController@packagePage')->name('admin.package');
        Route::get('/logout','LoginController@logout')->name('admin.logout');


        //get data
        Route::get('/get/users','AdminController@getUsers');
        Route::get('/get/category','AdminController@getCategory');
        Route::get('/get/language','AdminController@getLanguage');
        Route::get('/get/installation','AdminController@getInstallation');
        Route::get('/get/package','AdminController@getPackage');


        //get data with an id
        Route::get('/get/pack/lang/{id}', 'AdminController@getPackLang');
        Route::get('/get/pack/install/{id}', 'AdminController@getPackInstall');


        //post data
        Route::post('/post/user','AdminController@saveUser');
        Route::post('/post/category','AdminController@saveCategory');
        Route::post('/post/language','AdminController@saveLanguage');
        Route::post('/post/installation','AdminController@saveInstallation');
        Route::post('/post/package','AdminController@savePackage');


        //update post
        Route::post('/update/user', 'AdminController@updateUser');
        Route::post('/update/category', 'AdminController@updateCategory');
        Route::post('/update/language', 'AdminController@updateLanguage');
        Route::post('/update/installation', 'AdminController@updateInstallation');
        Route::post('/update/package', 'AdminController@updatePackage');
        Route::post('/change/password', 'AdminController@updatePassword');



        //delete data
        Route::delete('/delete/user/{id}', 'AdminController@deleteUser');
        Route::delete('/delete/category/{id}', 'AdminController@deleteCategory');
        Route::delete('/delete/language/{id}', 'AdminController@deleteLanguage');
        Route::delete('/delete/package/{id}', 'AdminController@deletePackage');
        Route::delete('/delete/installation/{id}', 'AdminController@deleteInstallation');
        Route::delete('/delete/pack/lang/{id}', 'AdminController@deletePackLang');
        Route::delete('/delete/pack/install/{id}', 'AdminController@deletePackInstall');


    });

});
