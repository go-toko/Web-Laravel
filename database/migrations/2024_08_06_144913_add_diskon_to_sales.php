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
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedDouble('total_discount')->default(0);
        });
        Schema::table('sales_details', function (Blueprint $table) {
            $table->unsignedDouble('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('total_discount');
        });
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
};
