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
        Schema::create('products_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('isActive')->default(true);
            $table->boolean('isParent')->default(false);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('products_brand', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('isActive')->default(true);
            $table->boolean('isParent')->default(false);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('sku');
            $table->integer('quantity');
            $table->string('unit');
            $table->integer('price_buy');
            $table->integer('price_sell');
            $table->string('images')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('products_category')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('products_brand')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_category');
        Schema::dropIfExists('products_brand');
    }
};
