<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id'); //unsigned integer auto-increment
            $table->text('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamp('published_at');
            $table->timestamps(); //auto crete created_at, updated_at
            $table->integer('user_id')->unsigned()->default(1);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
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
        Schema::drop('articles');
    }
}
