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
        // add column order_id (uuid) with default generated value
        Schema::table('sales', function (Blueprint $table) {
            $table->uuid('order_id')->after('id')->unique();
            $table->integer('changes')->after('total_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop column order_id
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('changes');
        });
    }
};
