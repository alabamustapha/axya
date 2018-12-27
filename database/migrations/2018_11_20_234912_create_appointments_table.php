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
            $table->string('slug');//->nullable()->unique();
            $table->tinyInteger('status')->default(0);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('doctor_id')->unsigned()->index();
            $table->date('day');
            $table->datetime('from')->nullable();
            $table->datetime('to')->nullable();
            $table->text('patient_info')->nullable();
            $table->datetime('sealed_at')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->boolean('reviewed')->default(0);

            $table->enum('type', ['Online', 'Home'])->default('Online');
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
