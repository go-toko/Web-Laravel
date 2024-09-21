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
        Schema::table('user_cashier', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('name');
            $table->dropColumn('birthDate');
            $table->dropColumn('gender');
            $table->dropColumn('picture');
            $table->dropColumn('phone');
            $table->dropColumn('status');
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cashier', function (Blueprint $table) {
            $table->string('username');
            $table->string('name');
            $table->date('birthDate')->nullable();
            $table->string('gender');
            $table->string('picture')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', [0, 1, 2])->default(0);
            $table->text('address')->nullable();
        });
    }
};
