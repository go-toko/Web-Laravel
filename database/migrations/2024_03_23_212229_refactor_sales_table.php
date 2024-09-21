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
        Schema::dropIfExists('sale_details_history');
        Schema::dropIfExists('sales_history');
        Schema::dropIfExists('sales_details');
        Schema::dropIfExists('sales');

        // add new table and column
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('shop_id');
            $table->uuid('order_id');
            $table->integer('total_bill');
            $table->integer('total_paid');
            $table->integer('changes');
            $table->enum('payment_method', ['CASH', 'QRIS']);
            $table->enum('status', ['UNPAID', 'PARTIAL_PAID', 'PAID', 'VOID ']);
            $table->timestamps();

            $table->foreign('cashier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('sales_details', function (Blueprint $table) {
            // Add new column
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('cashier_id');
            $table->string('name');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_details');
        Schema::dropIfExists('sales');
    }
};
