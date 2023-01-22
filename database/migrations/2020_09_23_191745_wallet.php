<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Wallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wallet', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_id');
            // $table->foreignId('wallet_id')->constrained('users');
            $table->string('user_type');
            $table->string('currency');
            // $table->bigIncrements('user_id');
            $table->bigInteger('total_balance')->default(0);
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('wallet');
    }
}
