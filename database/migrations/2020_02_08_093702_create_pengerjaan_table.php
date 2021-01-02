<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengerjaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('proyek_id');
            $table->foreign('proyek_id')->references('id')->on('project')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->boolean('selesai')->default(false);
            $table->text('file_hasil')->nullable();
            $table->text('tautan')->nullable();
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
        Schema::dropIfExists('pengerjaan');
    }
}
