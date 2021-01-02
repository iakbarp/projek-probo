<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->foreignId('user_from');
            $table->foreign('user_from')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('user_to');
            $table->foreign('user_to')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->index('user_from');
            $table->index('user_to');
            $table->boolean('read')->default(false);

            $table->bigInteger('reply_id')->nullable();
            $table->index('reply_id');
            $table->string('message',100);





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
        Schema::dropIfExists('message');
    }
}
