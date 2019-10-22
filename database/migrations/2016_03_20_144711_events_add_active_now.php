<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsAddActiveNow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
        Schema::table('events', function (Blueprint $table) {
            $table->enum('active_now', ['Y', 'N'])->default('N');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      /*
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('active_now');
        });
        */
    }
}
