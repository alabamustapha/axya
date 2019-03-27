<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logins', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->ipAddress('ip');
            $table->string('device')->nullable(); // NULLABLE() to be removed when script is set
            $table->string('os')->nullable();     // NULLABLE() to be removed when script is set
            $table->enum('type', ['r','l','n']); // r:registration, l:login, n:unknown
            $table->string('agent')->nullable();
            /**/
            $table->integer('logged_in_seconds')->nullable();
            $table->integer('logged_in_minutes')->nullable();
            $table->integer('logged_in_hours')->nullable();
            /**/
            $table->timestamp('last_activity_at')->nullable(); 
            $table->timestamp('logged_out_at')->nullable();// Set at AuthenticatesUsers@logout update->NOW()
            $table->string('browser');
            $table->string('referer_page')->nullable();
            $table->string('exit_page')->nullable();
            $table->string('session_id')->nullable();
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
        Schema::dropIfExists('logins');
    }
}
