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
        Schema::create('merchant_payment', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string("provider");
            $table->integer("min_transaksi");
            $table->integer("max_transaksi");
            $table->integer("min_settlement");
            $table->integer("max_settlement");
            $table->integer("fee");
            $table->enum("type_fee", ["PERCENTAGE", "NOMINAL"]);
            $table->enum("status", ["ACTIVE", "INACTIVE"]);
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
        Schema::dropIfExists('merchant_payment');
    }
};
