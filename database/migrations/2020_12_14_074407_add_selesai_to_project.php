<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelesaiToProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('project', function (Blueprint $table) {
        //     $table->boolean('selesai')->default(false);

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('project', function (Blueprint $table) {
        //     $table->dropColumn('selesai');
        // });
    }
}
