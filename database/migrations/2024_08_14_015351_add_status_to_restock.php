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
        Schema::table('restock', function (Blueprint $table) {
            $table->enum('status', ['PROSES', 'SIAP DITAMBAHKAN', 'SELESAI', 'BATAL'])->default('PROSES');
        });
        Schema::table('restock_detail', function (Blueprint $table) {
            $table->unsignedDouble('price_sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restock', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('restock_detail', function (Blueprint $table) {
            $table->dropColumn('price_sell');
        });
    }
};
