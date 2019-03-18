<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name')->index();
            $table->string('slug')->unique();
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

            // Authorization Details
            $table->boolean('acl')->default(3);
            $table->boolean('blocked')->default(0);
            $table->boolean('admin_mode')->default(0);
            $table->string('admin_password')->nullable();
            $table->boolean('doctor_mode')->default(0);
            $table->string('doctor_password')->nullable();

            // Other Details
            $table->tinyInteger('application_status')->default(0); // Tracks current status in doctor's application process.
            $table->boolean('as_doctor')->default(0);

            $table->string('last_four',4)->nullable();
            $table->string('verification_link')->nullable();
            $table->boolean('terms')->default(0);
            $table->timestamp('application_retry_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // DB::statement('ALTER TABLE users ADD FULLTEXT fulltext_users (name)');
        // DB::statement('CREATE FULLTEXT INDEX fulltext_users ON users (name)');
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
