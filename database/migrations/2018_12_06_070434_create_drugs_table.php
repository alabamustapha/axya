<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('dosage'); // eg 500mg: numeric
            $table->string('usage');
            $table->string('texture', 100)->default('others');
            $table->string('comment')->nullable();
            $table->integer('prescription_id')->unsigned();
            $table->timestamps();

            $table->foreign('prescription_id')
                  ->references('id')->on('prescriptions')
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
        Schema::dropIfExists('drugs');
    }
}
