<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); 
            $table->integer('amount')->default(0); 
            $table->tinyInteger('status')->default(0); //0=Processing, 1=Recieved, 2=Paid
            $table->string('transaction_id', 100)->nullable(); 
            $table->string('processor_transaction_id', 100)->nullable(); 
            $table->string('bank_account_id'); 

            $table->timestamp('confirmed_at')->nullable(); 
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bank_account_id')
                  ->references('id')->on('bank_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
}
