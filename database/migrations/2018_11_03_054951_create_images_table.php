<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('caption')->nullable();

            $table->string('url');
            $table->string('medium_url')->nullable();
            $table->string('thumbnail_url')->nullable();

            $table->integer('imageable_id');
            $table->string('imageable_type');
            $table->boolean('cover')->default(0); // [0,1] Stands as main pic from among many for a Model 
                                                 // eg User->dp, Page->coverImage. One/Model.
            $table->string('mime')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('images');
    }
}
