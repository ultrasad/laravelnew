<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsBrandDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('events', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
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
            $table->dropColumn('deleted_at');
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        */
    }
}
