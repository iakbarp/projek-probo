<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKematianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kematian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dokumen_id')->nullable();
            $table->foreign('dokumen_id')->references('id')->on('status_dokumen')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
//            $table->string('nik');
//            $table->text('name');
            $table->text('pt')->nullable();
            $table->text('dept')->nullable();
            $table->text('meninggal')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('bank')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('rekening')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->foreign('kota_id')->references('id')->on('kota')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('status_meninggal')->nullable();
//            $table->string('nominal');
            $table->text('alm')->nullable();
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
        Schema::dropIfExists('kematian');
    }
}
