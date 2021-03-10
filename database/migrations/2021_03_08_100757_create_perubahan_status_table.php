<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerubahanStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perubahan_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dokumen_id')->nullable();
            $table->foreign('dokumen_id')->references('id')->on('status_dokumen')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('perubahan')->nullable();
            $table->text('sebelum')->nullable();
            $table->text('sesudah')->nullable();
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
        Schema::dropIfExists('perubahan_status');
    }
}
