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
        DB::statement("create view view_saldo as SELECT `a`.`id`
       AS
       `id`,
       `a`.`topup` - `a`.`withdraw` - `a`.`pembayaran` -
       `a`.`pembayaran_layanan` AS
       `saldo`
        FROM   (SELECT `u`.`id`                            AS `id`,
               (SELECT Ifnull(Sum(`t`.`jumlah`), 0)
                FROM   `topup` `t`
                WHERE  `t`.`user_id` = `u`.`id` and konfirmasi=1)   AS `topup`,
               (SELECT Ifnull(Sum(`w`.`jumlah`), 0)
                FROM   `withdraw` `w`
                WHERE  `w`.`user_id` = `u`.`id`
                       AND `w`.`konfirmasi` = 1)   AS `withdraw`,
               (SELECT Ifnull(Sum(`p`.`bayar_pakai_dompet`), 0)
                FROM   (`pembayaran` `p`
                        JOIN `project` `pr`
                          ON( `pr`.`id` = `p`.`proyek_id`
                              AND `p`.`isdompet` = 1 ))
                WHERE  `pr`.`user_id` = `u`.`id`)  AS `pembayaran`,
               (SELECT Ifnull(Sum(`pl`.`bayar_pakai_dompet`), 0)
                FROM   (`pembayaran_layanan` `pl`
                        JOIN `pengerjaan_layanan` `pl2`
                          ON( `pl2`.`id` = `pl`.`pengerjaan_layanan_id`
                              AND `pl`.`isdompet` = 1 ))
                WHERE  `pl2`.`user_id` = `u`.`id`) AS `pembayaran_layanan`
        FROM   `users` `u`) `a`");
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
