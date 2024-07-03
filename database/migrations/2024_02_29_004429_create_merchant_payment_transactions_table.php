<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('sales_id');
            $table->string('transaction_ref')->unique();
            $table->string('payment_type');
            $table->integer('amount');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('sales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('payment_id')->references('id')->on('merchant_payment')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('shop_id')->references('id')->on('shops')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_payment_transactions');
    }
};
