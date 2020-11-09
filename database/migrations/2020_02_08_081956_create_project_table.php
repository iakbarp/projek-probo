<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('subkategori_id');
            $table->foreign('subkategori_id')->references('id')->on('subkategori')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('judul');
            $table->text('permalink')->unique();
            $table->text('deskripsi');
            $table->string('thumbnail')->nullable();
            $table->text('lampiran')->nullable();
            $table->string('waktu_pengerjaan');
            $table->string('harga');
            $table->boolean('pribadi');
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
        Schema::dropIfExists('project');
    }
}
