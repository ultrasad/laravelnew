<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url_slug', 100)->unique()->nullable();
            $table->string('logo_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('slogan')->nullable();
            $table->text('detail')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('line_officail')->nullable();
            $table->string('youtube')->nullable();
            $table->enum('approve_status', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brand')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('brand');
    }
}
