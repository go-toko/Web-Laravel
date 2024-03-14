<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_payment_withdrawal', function (Blueprint $table) {
            $table->id();
            $table->string('bank');
            $table->string('account_number');
            $table->string('account_name');
            $table->unsignedBigInteger('shop_id');
            $table->integer('amount');
            $table->enum('status', ['created', 'process', 'success', 'failed'])->default('created');
            $table->string('note')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('merchant_payment_withdrawal');
    }
};
