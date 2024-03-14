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
        Schema::dropIfExists('sale_details');
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('cashier_id');
            
            $table->string("name");            
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('sales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('shop_id')->references('id')->on('shops')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('cashier_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
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
    }
};
