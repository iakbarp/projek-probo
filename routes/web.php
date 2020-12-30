<?php

Route::group(['prefix' => '/', 'namespace' => 'Pages'], function () {

    Route::get('/', [
        'uses' => 'MainController@index',
        'as' => 'beranda'
    ]);
    Route::get('suratkontrak',[
        'uses' => 'MainController@suratKontrak',
        'as' => 'user.surat-kontrak'
    ]);

    Route::group(['prefix' => 'cari'], function () {

        Route::get('/', [
            'uses' => 'CariController@cariData',
            'as' => 'cari.data'
        ]);

        Route::get('data', [
            'uses' => 'CariController@getCariData',
            'as' => 'get.cari.data'
        ]);

        Route::get('judul/data', [
            'uses' => 'CariController@getCariJudulData',
            'as' => 'get.cari-judul.data'
        ]);

    });

    Route::group(['namespace' => 'Users', 'prefix' => 'profil/{username}'], function () {

        Route::get('/', [
            'uses' => 'UserController@profilUser',
            'as' => 'profil.user'
        ]);

        Route::post('hire-me', [
            'middleware' => ['auth', 'user', 'user.bio'],
            'uses' => 'UserController@userHireMe',
            'as' => 'user.hire-me'
        ]);

        Route::post('invite-to-bid', [
            'middleware' => ['auth', 'user', 'user.bio'],
            'uses' => 'UserController@userInviteToBid',
            'as' => 'user.invite-to-bid'
        ]);

    });

    Route::get('proyek/{username}/{judul}', [
        'uses' => 'MainController@detailProyek',
        'as' => 'detail.proyek'
    ]);

    Route::post('proyek/bid/submit', [
        'uses' => 'MainController@bidProyek',
        'as' => 'bid.proyek'
    ]);

    Route::get('layanan/{username}/{judul}', [
        'uses' => 'MainController@detailLayanan',
        'as' => 'detail.layanan'
    ]);

    Route::get('layanan/{username}/{judul}/pesan', [
        'middleware' => ['auth', 'user', 'user.bio'],
        'uses' => 'MainController@pesanLayanan',
        'as' => 'pesan.layanan'
    ]);

    Route::get('tentang', [
        'uses' => 'MainController@tentang',
        'as' => 'tentang'
    ]);

    Route::get('cara-kerja', [
        'uses' => 'MainController@caraKerja',
        'as' => 'cara-kerja'
    ]);

    Route::get('ketentuan-layanan', [
        'uses' => 'MainController@ketentuanLayanan',
        'as' => 'ketentuan-layanan'
    ]);

    Route::get('kebijakan-privasi', [
        'uses' => 'MainController@kebijakanPrivasi',
        'as' => 'kebijakan-privasi'
    ]);

    Route::group(['prefix' => 'testimoni', 'middleware' => 'auth'], function () {

        Route::post('kirim', [
            'uses' => 'MainController@kirimTestimoni',
            'as' => 'kirim.testimoni'
        ]);

        Route::get('{id}/hapus', [
            'uses' => 'MainController@hapusTestimoni',
            'as' => 'hapus.testimoni'
        ]);

    });

    Route::group(['prefix' => 'kontak'], function () {

        Route::get('/', [
            'uses' => 'MainController@kontak',
            'as' => 'kontak'
        ]);

        Route::post('kirim', [
            'uses' => 'MainController@kirimKontak',
            'as' => 'kirim.kontak'
        ]);

    });

});

Route::post('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Auth::routes();

Route::group(['prefix' => 'akun'], function () {

    Route::get('cek/{username}', [
        'uses' => 'Auth\RegisterController@cekUsername',
        'as' => 'cek.username'
    ]);

    Route::post('masuk', [
        'uses' => 'Auth\LoginController@login',
        'as' => 'login'
    ]);

    Route::post('keluar', [
        'uses' => 'Auth\LoginController@logout',
        'as' => 'logout'
    ]);

    Route::group(['namespace' => 'Pages\Users', 'middleware' => ['auth', 'user']], function () {

        Route::group(['namespace' => 'Klien', 'prefix' => 'dashboard/klien'], function () {

            Route::group(['prefix' => 'proyek'], function () {

                Route::get('/', [
                    'uses' => 'ProyekController@dashboard',
                    'as' => 'dashboard.klien.proyek'
                ]);

                Route::post('tambah', [
                    'uses' => 'ProyekController@tambahProyek',
                    'as' => 'klien.tambah.proyek'
                ]);

                Route::get('sunting/{id}', [
                    'uses' => 'ProyekController@suntingProyek',
                    'as' => 'klien.sunting.proyek'
                ]);

                Route::put('update', [
                    'uses' => 'ProyekController@updateProyek',
                    'as' => 'klien.update.proyek'
                ]);

                Route::get('hapus/{id}', [
                    'uses' => 'ProyekController@hapusProyek',
                    'as' => 'klien.hapus.proyek'
                ]);

                Route::group(['prefix' => 'lampiran/{judul}'], function () {

                    Route::get('/', [
                        'uses' => 'ProyekController@lampiranProyek',
                        'as' => 'klien.lampiran.proyek'
                    ]);

                    Route::post('tambah', [
                        'uses' => 'ProyekController@tambahLampiran',
                        'as' => 'klien.tambah.lampiran'
                    ]);

                    Route::get('hapus/{file}', [
                        'uses' => 'ProyekController@hapusLampiran',
                        'as' => 'klien.hapus.lampiran'
                    ]);

                    Route::post('hapus-massal', [
                        'uses' => 'ProyekController@hapusMassalLampiran',
                        'as' => 'klien.hapus-massal.lampiran'
                    ]);

                });

                Route::get('bid/{judul}', [
                    'uses' => 'ProyekController@bidProyek',
                    'as' => 'klien.bid.proyek'
                ]);

                Route::get('bid/{judul}/terima/{id}', [
                    'uses' => 'ProyekController@terimaBid',
                    'as' => 'klien.terima.bid'
                ]);

                Route::put('pembayaran/{id}/update', [
                    'uses' => 'ProyekController@updatePembayaran',
                    'as' => 'klien.update-pembayaran.proyek'
                ]);

                Route::get('pembayaran/{id}/data', [
                    'uses' => 'ProyekController@dataPembayaran',
                    'as' => 'klien.data-pembayaran.proyek'
                ]);

                Route::post('pengerjaan/{id}/ulas', [
                    'uses' => 'ProyekController@ulasPengerjaanProyek',
                    'as' => 'klien.ulas-pengerjaan.proyek'
                ]);

                Route::get('pengerjaan/{id}/ulas/data', [
                    'uses' => 'ProyekController@dataUlasanProyek',
                    'as' => 'klien.data-ulasan.proyek'
                ]);

            });

            Route::group(['prefix' => 'layanan'], function () {

                Route::get('/', [
                    'uses' => 'LayananController@dashboard',
                    'as' => 'dashboard.klien.layanan'
                ]);

                Route::get('pesanan/{id}/batalkan', [
                    'uses' => 'LayananController@batalkanPesanan',
                    'as' => 'klien.batalkan.pesanan'
                ]);

                Route::put('pembayaran/{id}/update', [
                    'uses' => 'LayananController@updatePembayaran',
                    'as' => 'klien.update-pembayaran.pesanan'
                ]);

                Route::get('pembayaran/{id}/data', [
                    'uses' => 'LayananController@dataPembayaran',
                    'as' => 'klien.data-pembayaran.pesanan'
                ]);

                Route::post('pengerjaan/{id}/ulas', [
                    'uses' => 'LayananController@ulasPengerjaanLayanan',
                    'as' => 'klien.ulas-pengerjaan.layanan'
                ]);

                Route::get('pengerjaan/{id}/ulas/data', [
                    'uses' => 'LayananController@dataUlasanLayanan',
                    'as' => 'klien.data-ulasan.layanan'
                ]);

            });

        });

        Route::group(['namespace' => 'Pekerja', 'prefix' => 'dashboard/pekerja'], function () {

            Route::group(['prefix' => 'proyek'], function () {

                Route::get('/', [
                    'uses' => 'ProyekController@dashboard',
                    'as' => 'dashboard.pekerja.proyek'
                ]);

                Route::get('bid/{id}/batalkan', [
                    'uses' => 'ProyekController@batalkanBid',
                    'as' => 'pekerja.batalkan.bid'
                ]);

                Route::get('undangan/{id}/terima', [
                    'uses' => 'ProyekController@terimaUndangan',
                    'as' => 'pekerja.terima.undangan'
                ]);

                Route::get('undangan/{id}/tolak', [
                    'uses' => 'ProyekController@tolakUndangan',
                    'as' => 'pekerja.tolak.undangan'
                ]);

                Route::get('lampiran/{id}', [
                    'uses' => 'ProyekController@lampiranProyek',
                    'as' => 'pekerja.lampiran.proyek'
                ]);

                Route::put('pengerjaan/{id}/update', [
                    'uses' => 'ProyekController@updatePengerjaanProyek',
                    'as' => 'pekerja.update-pengerjaan.proyek'
                ]);

                Route::put('pengerjaan/{id}/updateprogress',[
                   'uses' => 'ProyekController@updatePengerjaanProgressProyek',
                    'as' => 'pekerja-update-progress.proyek'
                ]);

                Route::get('pengerjaanprogress/{id}/data',[
                    'uses' => 'ProyekController@dataProgressPengerjaan',
                    'as' => 'pekerja-data-progress.proyek'
                    ]);

                Route::post('pengerjaan/{id}/ulas', [
                    'uses' => 'ProyekController@ulasPengerjaanProyek',
                    'as' => 'pekerja.ulas-pengerjaan.proyek'
                ]);

                Route::get('pengerjaan/{id}/ulas/data', [
                    'uses' => 'ProyekController@dataUlasanProyek',
                    'as' => 'pekerja.data-ulasan.proyek'
                ]);

                Route::get('download/contract/{id}',[
                    'uses' => 'ProyekController@download_contract',
                    'as' => 'download.contract'
                ]);

            });

            Route::group(['prefix' => 'layanan'], function () {

                Route::get('/', [
                    'uses' => 'LayananController@dashboard',
                    'as' => 'dashboard.pekerja.layanan'
                ]);

                Route::post('tambah', [
                    'uses' => 'LayananController@tambahLayanan',
                    'as' => 'pekerja.tambah.layanan'
                ]);

                Route::get('sunting/{id}', [
                    'uses' => 'LayananController@suntingLayanan',
                    'as' => 'pekerja.sunting.layanan'
                ]);

                Route::put('update', [
                    'uses' => 'LayananController@updateLayanan',
                    'as' => 'pekerja.update.layanan'
                ]);

                Route::get('hapus/{id}', [
                    'uses' => 'LayananController@hapusLayanan',
                    'as' => 'pekerja.hapus.layanan'
                ]);

                Route::put('pengerjaan/{id}/update', [
                    'uses' => 'LayananController@updatePengerjaanLayanan',
                    'as' => 'pekerja.update-pengerjaan.layanan'
                ]);

            });

        });

        Route::group(['prefix' => 'profil'], function () {

            Route::get('/', [
                'uses' => 'AkunController@profil',
                'as' => 'user.profil'
            ]);

            Route::put('update', [
                'uses' => 'AkunController@updateProfil',
                'as' => 'user.update.profil'
            ]);

            Route::group(['prefix' => 'portofolio'], function () {

                Route::post('tambah', [
                    'uses' => 'AkunController@tambahPortofolio',
                    'as' => 'tambah.portofolio'
                ]);

                Route::put('update', [
                    'uses' => 'AkunController@updatePortofolio',
                    'as' => 'update.portofolio'
                ]);

                Route::get('hapus/{id}', [
                    'uses' => 'AkunController@hapusPortofolio',
                    'as' => 'hapus.portofolio'
                ]);

            });

            Route::group(['prefix' => 'bahasa'], function () {

                Route::post('tambah', [
                    'uses' => 'AkunController@tambahBahasa',
                    'as' => 'tambah.bahasa'
                ]);

                Route::put('update', [
                    'uses' => 'AkunController@updateBahasa',
                    'as' => 'update.bahasa'
                ]);

                Route::get('hapus/{id}', [
                    'uses' => 'AkunController@hapusBahasa',
                    'as' => 'hapus.bahasa'
                ]);

            });

            Route::group(['prefix' => 'skill'], function () {

                Route::post('tambah', [
                    'uses' => 'AkunController@tambahSkill',
                    'as' => 'tambah.skill'
                ]);

                Route::put('update', [
                    'uses' => 'AkunController@updateSkill',
                    'as' => 'update.skill'
                ]);

                Route::get('hapus/{id}', [
                    'uses' => 'AkunController@hapusSkill',
                    'as' => 'hapus.skill'
                ]);

            });

        });

        Route::get('pengaturan', [
            'uses' => 'AkunController@pengaturan',
            'as' => 'user.pengaturan'
        ]);

        Route::put('pengaturan/update', [
            'uses' => 'AkunController@updatePengaturan',
            'as' => 'user.update.pengaturan'
        ]);

        Route::get('chat', [
            'uses' => 'ChatController@index',
            'as' => 'chat'
        ]);

        Route::get('dompet', [
            'uses' => 'DompetController@index',
            'as' => 'user.dompet'
        ]);
//        Route::get('dompet/saldo', [
//            'uses' => 'DompetController@dompetUser',
//            'as' => 'user.saldo'
//        ]);
        Route::put('dompet/update', [
            'uses' => 'DompetController@updatePengaturan',
            'as' => 'user.dompet.update.pengaturan'
        ]);

        Route::post('dompet/withdraw',[
            'uses' => 'DompetController@withdrawSaldo',
            'as' => 'user.withdraw.saldo'
        ]);

        Route::post('check_pin',[
            'uses' => 'DompetController@check_pin',
            'as' => 'user.check_pin'
        ]);
    });

});
