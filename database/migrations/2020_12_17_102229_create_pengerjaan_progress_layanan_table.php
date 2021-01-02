<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengerjaanProgressLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengerjaan_progress_layanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id'); //id klien
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('pengerjaan_layanan_id');
            $table->foreign('pengerjaan_layanan_id')->references('id')->on('pengerjaan_layanan')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('bukti_gambar', 255)->nullable();
            $table->string('deskripsi', 255);
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
        Schema::dropIfExists('pengerjaan_progress_layanan');
    }
}
