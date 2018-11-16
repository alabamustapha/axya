<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('description');
            $table->integer('specialty_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->foreign('specialty_id')
                  ->references('id')->on('specialties')
                  ->onDelete('cascade');
        });

        // DB::statement('ALTER TABLE tags ADD FULLTEXT fulltext_tags (description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
