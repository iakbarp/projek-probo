<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengerjaanProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengerjaan_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); //id klien
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('proyek_id');
            $table->foreign('proyek_id')->references('id')->on('project')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('pengerjaan_id');
            $table->foreign('pengerjaan_id')->references('id')->on('pengerjaan')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('bukti_gambar',255)->nullable();
            $table->string('deskripsi',255);
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
        Schema::dropIfExists('pengerjaan_progress');
    }
}
