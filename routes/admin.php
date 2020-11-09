<?php

Route::group(['namespace' => 'Pages\Admins', 'prefix' => 'sys-admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', [
        'uses' => 'AdminController@index',
        'as' => 'admin.dashboard'
    ]);

    Route::group(['prefix' => 'account'], function () {

        Route::get('admin/show', [
            'uses' => 'AdminController@admin',
            'as' => 'admin.show.admin'
        ]);

        Route::get('user/show', [
            'uses' => 'AdminController@other',
            'as' => 'admin.show.user'
        ]);

        Route::get('user/show/{username}', [
            'uses' => 'AdminController@other_detail',
            'as' => 'admin.show.user.detail'
        ]);

        Route::get('profile', [
            'uses' => 'AdminController@editProfile',
            'as' => 'admin.edit.profile'
        ]);

        Route::post('profile/update', [
            'uses' => 'AdminController@updateProfile',
            'as' => 'admin.update.profile'
        ]);

        Route::get('settings', [
            'uses' => 'AdminController@accountSettings',
            'as' => 'admin.settings'
        ]);

        Route::post('settings/update', [
            'uses' => 'AdminController@updateAccount',
            'as' => 'admin.update.account'
        ]);

        Route::post('add/admin', [
            'uses' => 'AdminController@add_admin',
            'as' => 'admin.add'
        ]);

    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('project', [
            'uses' => 'PembayaranController@project',
            'as' => 'admin.project.show'
        ]);

        Route::post('project/done', [
            'uses' => 'PembayaranController@project_done',
            'as' => 'admin.project.done'
        ]);


        Route::get('service', [
            'uses' => 'PembayaranController@service',
            'as' => 'admin.service.show'
        ]);

        Route::post('service/done', [
            'uses' => 'PembayaranController@service_done',
            'as' => 'admin.service.done'
        ]);
    });

    Route::group(['prefix' => 'master'], function () {
        Route::get('project', [
            'uses' => 'MasterProjectServiceController@project',
            'as' => 'admin.show.project'
        ]);

        Route::get('service', [
            'uses' => 'MasterProjectServiceController@service',
            'as' => 'admin.show.service'
        ]);

    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::get('show', [
            'uses' => 'KategoriSubController@index',
            'as' => 'admin.show.kategori'
        ]);

        Route::post('store',[
            'uses' => 'KategoriSubController@store_kategori',
            'as' => 'admin.show.kategori.store'
        ]);

        Route::post('update',[
            'uses' => 'KategoriSubController@update_kategori',
            'as' => 'admin.show.kategori.update'
        ]);

        Route::post('{id}/delete', [
            'uses' => 'KategoriSubController@delete_kategori',
            'as' => 'admin.show.kategori.delete'
        ]);
    });

    Route::group(['prefix' => 'subkategori'], function () {

        Route::post('store',[
            'uses' => 'KategoriSubController@store_subkategori',
            'as' => 'admin.show.subkategori.store'
        ]);

        Route::post('update',[
            'uses' => 'KategoriSubController@update_subkategori',
            'as' => 'admin.show.subkategori.update'
        ]);

        Route::post('{id}/delete', [
            'uses' => 'KategoriSubController@delete_subkategori',
            'as' => 'admin.show.subkategori.delete'
        ]);
    });

    Route::group(['prefix' => 'loc'], function () {

        Route::group(['prefix' => 'negara'], function () {
            Route::get('/', [
                'uses' => 'LokasiController@negara',
                'as' => 'admin.show.negara'
            ]);

            Route::post('store',[
                'uses' => 'LokasiController@store_negara',
                'as' => 'admin.show.negara.store'
            ]);

            Route::post('update',[
                'uses' => 'LokasiController@update_negara',
                'as' => 'admin.show.negara.update'
            ]);

            Route::post('{id}/delete', [
                'uses' => 'LokasiController@negaradelete',
                'as' => 'admin.show.negara.delete'
            ]);

        });

        Route::group(['prefix' => 'provinsi'], function () {
            Route::get('/', [
                'uses' => 'LokasiController@provinsi',
                'as' => 'admin.show.provinsi'
            ]);

            Route::post('store',[
                'uses' => 'LokasiController@store_provinsi',
                'as' => 'admin.show.provinsi.store'
            ]);

            Route::post('update',[
                'uses' => 'LokasiController@update_provinsi',
                'as' => 'admin.show.provinsi.update'
            ]);

            Route::post('{id}/delete', [
                'uses' => 'LokasiController@provinsidelete',
                'as' => 'admin.show.provinsi.delete'
            ]);
        });
    });

    Route::group(['prefix' => 'api'], function () {
        Route::get('profile', [
            'uses' => 'AdminController@editProfile',
            'as' => 'admin.edit.profile'
        ]);
    });


});
