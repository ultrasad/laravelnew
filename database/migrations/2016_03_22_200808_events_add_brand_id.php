<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsAddBrandId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('events', function (Blueprint $table) {
          $table->integer('brand_id')->unsigned()->default(1);
          $table->foreign('brand_id')
          ->references('id')
          ->on('brand')
          ->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::table('events', function (Blueprint $table) {
            //
        //});
    }
}
