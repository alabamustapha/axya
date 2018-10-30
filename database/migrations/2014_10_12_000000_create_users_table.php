<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // Basic Details
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('avatar')->nullable()->default('images/doc.jpg');
            $table->enum('gender', ['Female', 'Male', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('password');

            // Contact Details
            $table->string('email')->unique();
            $table->string('phone', 25)->nullable();
            $table->string('address')->nullable();

            // Health Details
            $table->string('height', 10)->nullable();
            $table->string('weight', 10)->nullable();
            $table->string('allergies')->nullable();
            $table->string('chronics')->nullable();

            // AUthorization Details
            $table->boolean('acl')->default(3);
            $table->boolean('is_doctor')->default(0); // Determined after application & verification of docs.
            $table->boolean('blocked')->default(0);

            // Other Details
            $table->string('last_four',4)->nullable();
            $table->boolean('terms')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
