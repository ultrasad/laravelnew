<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
          $table->increments('id'); //unsigned integer auto-increment
          $table->text('title');
          $table->string('url_slug', 100)->unique()->nullable();
          $table->string('image')->nullable();
          $table->string('brief')->nullable();
          $table->text('description');
          $table->date('start_date');
          $table->date('end_date');
          $table->enum('active', ['Y', 'N'])->default('Y');
          $table->date('published_at')->nullable();
          $table->timestamps(); //auto crete created_at, updated_at
          $table->timestamp('deleted_at')->nullable();
          $table->integer('user_id')->unsigned()->default(1);
          $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
          $table->integer('brand_id')->unsigned()->default(1);
          /*$table->foreign('brand_id')
                ->references('id')
                ->on('brand')
                ->onDelete('cascade');*/
                //$table->rememberToken();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //Cate Name Space
            $table->string('category'); //cate-name-space
            $table->enum('category_type', ['event', 'brand']); //brand or event
            $table->string('icon', 60)->nullable(); //brand or event
            $table->integer('order_id')->unsigned()->default(1);
            $table->timestamps();
        });

        Schema::create('event_category', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')
                  ->on('events')->onDelete('cascade');

            $table->integer('cate_id')->unsigned()->index();
            $table->foreign('cate_id')->references('id')
                  ->on('categories')->onDelete('cascade');

            $table->timestamps();
        });

        /*
        Schema::table('tags', function (Blueprint $table) {
            $table->string('tag');
        });
        */

        Schema::create('event_tag', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')
                  ->on('events')->onDelete('cascade');

            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')
                  ->on('tags')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //Image Name
            $table->string('image'); //Image Path
            $table->timestamps();
        });

        Schema::create('event_gallery', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')
                  ->on('events')->onDelete('cascade');

            $table->integer('gallery_id')->unsigned()->index();
            $table->foreign('gallery_id')->references('id')
                  ->on('galleries')->onDelete('cascade');

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
        /*
        Schema::drop('events');
        Schema::drop('categories');
        Schema::drop('event_category');
        Schema::drop('event_tag');
        Schema::drop('images');
        Schema::drop('event_image');
        */

        /*Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('tag');
        });*/
    }
}
