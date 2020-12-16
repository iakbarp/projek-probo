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
        \DB::statement("CREATE VIEW view_saldo AS SELECT u.id,ifnull(sum(t.jumlah),0)-ifnull(sum(w.jumlah),0) as saldo
        from users as u
        LEFT JOIN withdraw as w on w.user_id=u.id and w.konfirmasi=1
        LEFT JOIN topup as t on t.user_id=u.id GROUP BY u.id,w.user_id,t.user_id");
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
