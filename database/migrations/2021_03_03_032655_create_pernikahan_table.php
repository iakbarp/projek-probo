<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePernikahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pernikahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dokumen_id')->nullable();
            $table->foreign('dokumen_id')->references('id')->on('status_dokumen')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('pt')->nullable();
            $table->text('dept')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('bank')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('rekening')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->foreign('kota_id')->references('id')->on('kota')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('tanggal_menikah')->nullable();
            $table->text('nama_istri')->nullable();
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
        Schema::dropIfExists('pernikahan');
    }
}
