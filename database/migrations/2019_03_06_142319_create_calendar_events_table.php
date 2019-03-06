<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->datetime('start');
            $table->datetime('end');
            $table->string('title', 100);   // Title of the event
            $table->string('content', 200); // Short details about the event
            $table->text('contentFull');    // More details about the event
            $table->string('class');        // CSS clas styling
            $table->string('icon');         // eg font-awesome fa-home
            $table->boolean('background')->default(false); // For background events, has special styling.

            $table->integer('eventable_id');
            $table->string('eventable_type');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_events');
    }
}
