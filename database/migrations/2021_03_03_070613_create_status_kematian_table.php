<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusKematianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_kematian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kematian_id');
            $table->foreign('kematian_id')->references('id')->on('kematian')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('jenis_perubahan')->nullable();
            $table->string('old_nik')->nullable();
            $table->string('new_nik')->nullable();
            $table->text('old_name')->nullable();
            $table->text('new_name')->nullable();
            $table->text('old_meninggal')->nullable();
            $table->text('new_meninggal')->nullable();
            $table->text('old_status_meninggal')->nullable();
            $table->text('new_status_meninggal')->nullable();
            $table->date('old_tanggal_kematian')->nullable();
            $table->date('new_tanggal_kematian')->nullable();
            $table->text('old_dept')->nullable();
            $table->text('new_dept')->nullable();
            $table->text('old_group')->nullable();
            $table->text('new_group')->nullable();
            $table->text('old_surat_kematian')->nullable();
            $table->text('new_surat_kematian')->nullable();
            $table->string('old_uang_duka')->nullable();
            $table->string('new_uang_duka')->nullable();
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
        Schema::dropIfExists('status_perubahan');
    }
}
