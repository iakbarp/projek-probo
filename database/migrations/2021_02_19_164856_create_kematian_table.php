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
            $table->string('nik');
            $table->text('name');
            $table->text('meninggal');
            $table->text('status_meninggal');
            $table->date('tanggal_kematian')->nullable();
            $table->text('dept');
            $table->text('group');
            $table->text('surat_kematian')->nullable();
            $table->string('uang_duka');
//            $table->text('akte_kematian')->nullable();
            $table->boolean('validasi')->nullable();
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
