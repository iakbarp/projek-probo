<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSelesaiToPengerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('pengerjaan', function (Blueprint $table) {
        //     $table->dropColumn('selesai');

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('pengerjaan', function (Blueprint $table) {
        //     $table->boolean('selesai')->default(false);


        // });
    }
}
