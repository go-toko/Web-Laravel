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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('shop_id');
            $table->date('date');
            $table->string('customer_name');
            $table->integer('total');
            $table->integer('paid');
            $table->integer('change')->default(0);
            $table->string('payment_method');
            $table->enum('payment_status', ['lunas', 'hutang'])->default('lunas');
            $table->enum('status', ['selesai', 'tertunda', 'batal'])->default('selesai');
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('cashier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('buying_price');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->bigInteger('total_price');
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('sales_history', function (Blueprint $table) {
            $table->id();
            $table->string('sales_id');
            $table->string('shop_id');
            $table->date('date');
            $table->string('cashier_name');
            $table->string('customer_name');
            $table->integer('total');
            $table->integer('paid');
            $table->integer('change')->default(0);
            $table->string('payment_method');
            $table->enum('payment_status', ['lunas', 'hutang'])->default('lunas');
            $table->enum('status', ['selesai', 'tertunda', 'batal'])->default('selesai');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });

        Schema::create('sale_details_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_history_id');
            $table->string('product_name');
            $table->integer('buying_price');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->bigInteger('total_price');
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('sale_details');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sales_history');
        Schema::dropIfExists('sale_details_history');
    }
};
