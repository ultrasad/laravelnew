<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('image');
            $table->string('lat', 60);
            $table->string('lon', 60);
            $table->integer('zoom');
            $table->text('detail');
            $table->timestamps();
        });

        Schema::create('brand_branch', function (Blueprint $table) {
            $table->integer('brand_id')->unsigned()->index();
            $table->foreign('brand_id')->references('id')
                  ->on('brand')->onDelete('cascade');

            $table->integer('branch_id')->unsigned()->index();
            $table->foreign('branch_id')->references('id')
                  ->on('branch')->onDelete('cascade');

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
        //Schema::drop('branch');
        //Schema::drop('brand_branch');
    }
}
