<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'date')) {
                $table->dropColumn('date');
            }

            if (Schema::hasColumn('sales', 'customer_name')) {
                $table->dropColumn('customer_name');
            }

            if (Schema::hasColumn('sales', 'change')) {
                $table->dropColumn('change');
            }

            if (Schema::hasColumn('sales', 'isActive')) {
                $table->dropColumn('isActive');
            }

            if (Schema::hasColumn('sales', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

            if (Schema::hasColumn('sales', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('sales', 'payment_method')) {
                $table->dropColumn('payment_method');
            }

            if (Schema::hasColumn('sales', 'total')) {
                $table->renameColumn('total', 'total_bill');
            }

            if (Schema::hasColumn('sales', 'paid')) {
                $table->renameColumn('paid', 'total_paid');
            }
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->integer('total_item')->after('total_paid');
            $table->enum('status', ['UNPAID', 'PARTIAL_PAID', 'PAID','VOID'])->after('total_item');
            $table->enum('payment_method', ['CASH', 'QRIS'])->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
