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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function () {
    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });

    //tab
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/home', 'tabDataController@home');
        Route::get('/proyek', 'tabDataController@proyek');
        Route::get('/layanan', 'tabDataController@layanan');
        Route::get('/frelencer', 'tabDataController@frelencer');


    });



});
