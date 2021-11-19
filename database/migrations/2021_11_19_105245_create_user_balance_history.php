<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalanceHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balance_history', function (Blueprint $table) {
            $table->id();
            $table->integer('userBalanceId');
            $table->integer('balanceBefore');
            $table->integer('balanceAfter');
            $table->string('activity');
            $table->enum('type', ['debit', 'kredit']);
            $table->string('ip');
            $table->string('location');
            $table->string('userAgent');
            $table->string('author');
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
        Schema::dropIfExists('user_balance_history');
    }
}
