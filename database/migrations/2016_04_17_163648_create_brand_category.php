<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_category', function (Blueprint $table) {
          $table->integer('brand_id')->unsigned()->index();
          $table->foreign('brand_id')->references('id')
                ->on('brand')->onDelete('cascade');

          $table->integer('cate_id')->unsigned()->index();
          $table->foreign('cate_id')->references('id')
                ->on('categories')->onDelete('cascade');

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
        Schema::table('brand_category', function (Blueprint $table) {
            //
        });
    }
}
