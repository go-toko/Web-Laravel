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
        Schema::create('user_subscription', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_types_id');
            $table->unsignedBigInteger('user_id');
            $table->string('subscription_name');
            $table->integer('subscription_price');
            $table->integer('subscription_time');
            $table->string('payment_via')->nullable();
            $table->timestamp('expire');
            $table->enum('status', ['pending', 'paid'])->nullable();
            $table->timestamps();

            $table->foreign('subscription_types_id')->references('id')->on('subscription_types')
                  ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')
                  ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscription');
    }
};
