<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDompetHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dompet_history', function (Blueprint $table) {
            $table->string('id', 16);
            $table->primary('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->unsignedBigInteger('topup_id')->nullable();
            $table->foreign('topup_id')->references('id')->on('topup')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->unsignedBigInteger('withdraw_id')->nullable();
            $table->foreign('withdraw_id')->references('id')->on('withdraw')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->unsignedBigInteger('pembayaran_layanan_id')->nullable();
            $table->foreign('pembayaran_layanan_id')->references('id')->on('pembayaran_layanan')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->unsignedBigInteger('pembayaran_id')->nullable();
            $table->foreign('pembayaran_id')->references('id')->on('pembayaran')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->double('jumlah')->default(0);

            $table->timestamp('created_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dompet_history');
    }
}
