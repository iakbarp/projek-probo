<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBayarPakaiDompetToPembayaranLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran_layanan', function (Blueprint $table) {
                        $table->double('bayar_pakai_dompet')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran_layanan', function (Blueprint $table) {
                        $table->dropColumn('bayar_pakai_dompet')->default(0);
        });
    }
}
