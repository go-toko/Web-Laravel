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
        Schema::create('expenses_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('isActive')->default(true);
            $table->boolean('isParent')->default(false);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('shop_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->bigInteger('amount');
            $table->date('date');
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('expenses_category')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expenses_category');
        Schema::dropIfExists('expenses_history');
    }
};
