<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->integer('prescription_id')->unsigned()->nullable();
            $table->integer('appointment_id')->unsigned()->nullable();
            $table->text('description');
            $table->datetime('start_date');
            $table->time('start_time');
            $table->datetime('end_date');
            $table->integer('notify_by')->default(15); // Minutes to alert before actual time
            $table->integer('recurrence')->default(0); // Eg every 4hrs, 2days[in conjunction with reccurence type].
            $table->enum('recurrence_type', ['minutes', 'hours', 'days', 'weeks', 'months', 'years'])->default('hours');
            $table->timestamps();            

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('prescription_id')
                  ->references('id')->on('prescriptions')
                  ->onDelete('cascade');
            $table->foreign('appointment_id')
                  ->references('id')->on('appointments')
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
        Schema::dropIfExists('medications');
    }
}
