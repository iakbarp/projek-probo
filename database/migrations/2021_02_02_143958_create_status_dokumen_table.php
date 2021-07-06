<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_dokumen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('nik');
            $table->text('name');
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('r2');
            $table->string('nominal')->nullable();
            $table->text('terbilang')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('berkas')->nullable();
            $table->bigInteger('selesai')->nullable();
//            $table->text('kk')->nullable();
//            $table->text('akte')->nullable();
//            $table->text('surat_kematian')->nullable();
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
        Schema::dropIfExists('status_dokumen');
    }
}
