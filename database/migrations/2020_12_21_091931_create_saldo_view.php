<?php

use Illuminate\Support\Facades\DB;
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
        DB::statement("create view view_saldo as SELECT id, topup-withdraw-pembayaran-pembayaran_layanan saldo from (
            SELECT u.id,
        (select ifnull(sum(t.jumlah),0) from topup as t where t.user_id=u.id) as topup,
        (select ifnull(sum(w.jumlah),0) from withdraw as w where w.user_id=u.id and w.konfirmasi=1)  withdraw,
        (select ifnull(sum(p.jumlah_pembayaran),0) from pembayaran as p join project pr on pr.id=p.proyek_id and  p.isDompet=1 WHERE pr.user_id=u.id) pembayaran,
        (select ifnull(sum(pl.jumlah_pembayaran),0) from pembayaran_layanan as pl join pengerjaan_layanan pl2 on pl2.id=pl.pengerjaan_layanan_id and  pl.isDompet=1 where pl2.user_id=u.id) pembayaran_layanan

                from users as u) a");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(" DROP VIEW IF EXISTS `view_saldo`");
    }
}
