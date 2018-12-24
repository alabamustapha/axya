<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('comment');
            $table->enum('rating', [1,2,3,4,5])->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->integer('appointment_id')->unsigned();
            $table->timestamps();

            $table->unique(['id','user_id','doctor_id','appointment_id']);

            // OnDelete Cascade should be re-accessed to decide if to retain when related models are deleted
            // Also, a default dummy model should stand in if no deletion is planned.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
