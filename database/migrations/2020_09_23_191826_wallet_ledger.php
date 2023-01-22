<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WalletLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wallet_ledger', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_id');
            // $table->foreignId('wallet_id')->constrained('users');
            $table->string('transaction_type');
            $table->text('description');
            $table->string('transaction_id');
            $table->bigInteger('amount');
            $table->bigInteger('balance');
            $table->timestamps();
            // $table->foreign('wallet_id')->references('id')->on('wallet');
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
        Schema::dropIfExists('wallet_ledger');
    }
}
