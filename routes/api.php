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
        Route::get('/grup_kategori', 'tabDataController@grupKategori');


        Route::get('/aggrement_proyek', 'aggrementController@proyek');

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


        Route::group(['prefix' => 'public'], function () {
            Route::get('/', 'publicPreviewController@get');
            Route::get('/proyek', 'publicPreviewController@proyek');
            Route::get('/proyek/{id}', 'publicPreviewController@getProyek');
            Route::get('/layanan', 'publicPreviewController@layanan');
            Route::get('/portfolio', 'publicPreviewController@portfolio');
            Route::get('/ulasan', 'publicPreviewController@ulasan');
            Route::get('/layanan/{id}', 'publicPreviewController@getLayanan');
            Route::get('/layanan/{id}/order', 'publicPreviewController@orderLayanan');
            Route::post('/bid_proyek', 'publicPreviewController@bidProyek');
            Route::post('/terima_bid', 'publicPreviewController@terimaBid');
            Route::post('/invite_proyek', 'publicPreviewController@inviteProyek');
            Route::post('/invite_private', 'publicPreviewController@invitePrivate');
        });

        Route::group(['prefix' => 'klien'], function () {

            Route::group(['prefix' => 'proyek', 'namespace' => 'Users\Klien'], function () {
                Route::get('/', 'ProyekController@dashboard');
                Route::post('/', 'ProyekController@tambahProyek');
                Route::post('/lampiran', 'ProyekController@tambahLampiran');
                Route::delete('/lampiran', 'ProyekController@deleteLampiran');

                Route::group(['prefix' => 'payment'], function () {
                    Route::get('/', [
                        'uses' => 'ProyekPaymentController@index',

                    ]);
                    Route::post('/dompet', 'ProyekPaymentController@viaDompet');
                });

                Route::post('/{proyek_id}', 'ProyekController@updateProyek');
                Route::delete('/{proyek_id}', 'ProyekController@deleteProyek');
            });


            Route::group(['prefix' => 'layanan', 'namespace' => 'Users\Klien'], function () {
                Route::get('/', 'LayananController@dashboard');
                Route::delete('/{id}', 'LayananController@deleteOrder');
                Route::post('/{id}/ulasan', 'LayananController@komenLayanan');
            });
        });

        Route::group(['prefix' => 'pekerja', 'namespace' => 'Users\Pekerja'], function () {
            Route::group(['prefix' => 'layanan'], function () {
                Route::get('/', 'LayananController@dashboard');
                Route::post('/', 'LayananController@tambahLayanan');
                Route::post('/{proyek_id}', 'LayananController@updateLayanan');
                Route::delete('/{proyek_id}', 'LayananController@deleteLayanan');
            });

            Route::group(['prefix' => 'proyek'], function () {
                Route::get('/', 'ProyekController@dashboard');
                Route::delete('/bid', 'ProyekController@deleteBid');
                Route::post('/invitation', 'ProyekController@inviteApproval');
                Route::get('/progress', 'ProyekController@pengerjaanData');
                Route::post('/progress', 'ProyekController@pengerjaanPost');
            });
        });
    });



    Route::group(['prefix' => 'midtrans'], function () {

        Route::get('snap', [
            'uses' => 'MidtransController@snap',
            'as' => 'get.midtrans.snap'
        ]);

        Route::group(['prefix' => 'callback'], function () {

            /*Route::get('finish', [
                'uses' => 'MidtransController@finishCallback',
                'as' => 'get.midtrans-callback.finish'
            ]);
            Route::get('unfinish', [
                'uses' => 'MidtransController@unfinishCallback',
                'as' => 'get.midtrans-callback.unfinish'
            ]);*/

            Route::post('payment', [
                'uses' => 'MidtransController@notificationCallback',
                'as' => 'post.midtrans-callback.notification'
            ]);
        });
    });
});
