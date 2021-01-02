<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulasan_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); //id klien
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('pengerjaan_layanan_id');
            $table->foreign('pengerjaan_layanan_id')->references('id')->on('pengerjaan_layanan')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('deskripsi');
            $table->double('bintang');
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
        Schema::dropIfExists('ulasan_service');
    }
}
