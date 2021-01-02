<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanPekerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulasan_pekerja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); //id klien
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('pengerjaan_id');
            $table->foreign('pengerjaan_id')->references('id')->on('pengerjaan')
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
        Schema::dropIfExists('ulasan_pekerja');
    }
}
