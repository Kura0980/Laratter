<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user', 'UserController@authnication');
Route::post('/user/register', 'UserController@register');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user/{id}', 'UserController@show')->where('id', '[0-9]+');
    Route::get('/user/{id}/post', 'UserController@getPosts')->where('id', '[0-9]+');
    Route::get('/user/{id}/like', 'UserController@getLikes')->where('id', '[0-9]+');

    Route::post('/post', 'PostController@store');
    Route::post('/like', 'LikeController@store');
    Route::delete('/like/{id}', 'LikeController@destroy')->where('id', '[0-9]+');
});
