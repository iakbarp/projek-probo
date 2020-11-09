<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_layanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pengerjaan_layanan_id');
            $table->foreign('pengerjaan_layanan_id')->references('id')->on('pengerjaan_layanan')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->boolean('dp')->default(false);
            $table->string('jumlah_pembayaran')->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->boolean('selesai')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_layanan');
    }
}
