<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('specialty_id')->unsigned()->index();
            $table->date('first_appointment');
            $table->integer('region_id')->unsigned();
            $table->integer('city_id')->unsigned();  

            $table->string('workplace')->nullable();
            $table->string('workplace_address')->nullable();
            $table->date('workplace_start')->nullable();

            $table->string('specialist_diploma')->nullable();
            $table->string('competences')->nullable();
            $table->string('malpraxis')->nullable();
            $table->string('medical_college')->nullable();
            $table->date('medical_college_expiry')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('applications');
    }
}
