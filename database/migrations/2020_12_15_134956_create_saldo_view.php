<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("create view view_saldo as SELECT u.id,ifnull(sum(t.jumlah),0)-ifnull(sum(w.jumlah),0)-ifnull(sum(p.jumlah_pembayaran),0)-ifnull(sum(pl.jumlah_pembayaran),0) as saldo
        from users as u
        LEFT JOIN withdraw as w on w.user_id=u.id and w.konfirmasi=1
        LEFT JOIN (pembayaran as p  LEFT join project pr on pr.id=p.proyek_id and  p.isDompet=1) on pr.user_id=u.id
        LEFT JOIN (pembayaran_layanan as pl  LEFT join pengerjaan_layanan pl2 on pl2.id=pl.pengerjaan_layanan_id and  pl.isDompet=1) on pl2.user_id=u.id

        LEFT JOIN topup as t on t.user_id=u.id GROUP BY u.id,w.user_id,t.user_id
        order by u.id,w.user_id,pr.user_id,pl2.user_id,t.user_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement(" DROP VIEW IF EXISTS `view_saldo`");
    }

}
