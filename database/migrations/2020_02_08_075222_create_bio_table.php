<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('foto')->nullable();
            $table->string('latar_belakang')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->foreign('kota_id')->references('id')->on('kota')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('hp')->nullable();
            $table->string('status')->nullable();
            $table->text('summary')->nullable();
            $table->string('website')->nullable();
            $table->string('rekening')->nullable();
            $table->string('an')->nullable();
            $table->string('bank')->nullable();
            $table->decimal('total_bintang_pekerja', 8, 1)->nullable()->default(0);
            $table->decimal('total_bintang_klien', 8, 1)->nullable()->default(0);
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
        Schema::dropIfExists('bio');
    }
}
