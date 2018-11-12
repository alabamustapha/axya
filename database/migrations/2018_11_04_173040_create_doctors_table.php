<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->integer('id')->unique()->unsigned();
            $table->integer('user_id')->unique()->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->date('first_appointment');
            $table->string('slug');

            // $table->integer('specialty_id')->unsigned();
            $table->string('graduate_school')->nullable();
            $table->boolean('available')->default(0); // 0:Available, 1:Not Available.
            $table->timestamp('subscription_ends_at')->nullable();
            $table->timestamps();
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->unsigned()->nullable();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
