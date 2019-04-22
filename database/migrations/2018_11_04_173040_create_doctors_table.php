<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            // Profile
            $table->integer('id')->unique()->unsigned();
            $table->integer('user_id')->unique()->unsigned();
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('slug')->index();
            $table->text('about')->nullable();

            // Language
            $table->integer('main_language')->unsigneed()->default(1);
            $table->integer('second_language')->unsigned()->nullable();
            $table->string('other_languages')->nullable();

            // Location
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->string('home_address')->nullable();
            $table->string('work_address')->nullable();
            $table->string('location')->nullable()->index();
            $table->integer('region_id')->unsigned();
            $table->integer('city_id')->unsigned();      

            // Work
            $table->string('rate')->default('5.00'); // $ per session
            $table->integer('session')->default('30');// In Minutes
            $table->date('first_appointment');
            $table->boolean('available')->default(1); // 1:Available, 0:Not Available.
            $table->timestamp('subscription_ends_at')->nullable();

            // Education
            $table->string('graduate_school')->nullable();
            $table->string('degree')->nullable();
            $table->string('residency')->nullable();
            $table->integer('specialty_id')->unsigned();

            $table->timestamps();
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->unsigned()->nullable();
            $table->boolean('revoked')->default(0);
            $table->text('serialized_schedules')->nullable();

            $table->primary(['id', 'user_id']);

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('city_id')->references('id')->on('cities');

            // $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
        });

        // DB::statement('ALTER TABLE doctors ADD FULLTEXT fulltext_doctors (about)');

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
