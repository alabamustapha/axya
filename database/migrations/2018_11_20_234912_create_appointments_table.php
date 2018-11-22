<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(0);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('doctor_id')->unsigned()->index();
            $table->date('day');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->text('patient_info')->nullable();
            $table->datetime('sealed_at')->nullable();

            $table->enum('type', ['Online', 'Home'])->defualt('Online');
            $table->string('address')->nullable();
            $table->string('phone', 50)->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
