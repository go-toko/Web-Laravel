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
        Schema::table('merchant_payment_transactions', function (Blueprint $table) {
            $table->string('payment_url')->nullable()->after('amount');
            $table->text('description')->nullable()->after('payment_url');
            $table->dateTime('expired_at')->nullable()->after('status');
            $table->dateTime('payment_at')->nullable()->after('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_payment_transactions', function (Blueprint $table) {
            $table->dropColumn('payment_url');
            $table->dropColumn('description');
            $table->dropColumn('expired_at');
            $table->dropColumn('payment_at');
        });
    }
};
