<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('lat', 60);
          $table->string('lon', 60);
          $table->integer('zoom');
          $table->timestamps();
        });

        Schema::create('event_location', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')
                  ->on('events')->onDelete('cascade');

            $table->integer('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')
                  ->on('locations')->onDelete('cascade');

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
          //Schema::drop('locations');
          //Schema::drop('event_location');
    }
}
