<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/',function(){
    if(!empty(Session::get('uid'))){
        return redirect('postList');
    }
    return view('login');
});
Route::any('logout',function(){
    Session::flush('uid');
    return redirect('/');
});
//视图路由
Route::group(['prefix' => 'view'],function(){
    Route::any('/{url}', 'User\UserController@showPage');
});
Route::any('register',function(){
   return view('register');
});
Route::any('/check',['middleware' => 'register','uses' => 'User\UserController@create']);
Route::any('/loginBBS',['middleware' => 'checkLogin','uses' => 'Post\PostController@getPostList']);
Route::any('/postform',['middleware' => 'checkPost','uses' => 'Post\PostController@newPost']);
Route::get('/postDetail','Post\PostController@getPostDetail');
Route::get('/newPost',function(){
    return view('newPost');
});
Route::any('/postList','Post\PostController@getPostList');
Route::get('/reply','Post\PostController@reply');
Route::post('/replyForm','Post\PostController@replySubmit');
