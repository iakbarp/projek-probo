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
        Route::post('register', 'AuthController@register');

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
        Route::get('/kategori', 'tabDataController@kategori');

        Route::group(['prefix' => 'message'], function () {

            Route::get('/', 'messageController@index');
            Route::get('typing', 'messageController@eventTyping');
            Route::group(['middleware' => 'optimizeImages'], function () {

                Route::post('send', 'messageController@sendChat');
           
            });
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'userController@get');
            Route::post('/summary', 'userController@summary');

            Route::get('/edit', 'userController@edit');
            Route::post('/update', 'userController@update');

            Route::get('/negara', 'userController@negara');
            Route::get('/kota', 'userController@kota');
            Route::get('/bank', 'userController@bank');



            Route::get('/skills', 'userController@skills');
            Route::post('/skills_update', 'userController@skills_update');

            Route::group(['middleware' => 'optimizeImages'], function () {
                Route::post('/photo', 'userController@photo');

                Route::post('/portofolio', 'userController@portofolio');
                Route::post('/portofolio/{id}', 'userController@portofolio_update');
                Route::delete('/portofolio/{id}', 'userController@portofolio_delete');
            });
        });

        Route::group(['prefix' => 'klien'], function () {

            Route::group(['prefix' => 'proyek','namespace' => 'Users\Klien'], function () {
            Route::get('/', 'ProyekController@dashboard');

            });

        });

        Route::group(['prefix' => 'pekerja'], function () {
        });
    });
});
