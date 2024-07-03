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
            // check if column exists 
            if (Schema::hasColumn('user_cashier', 'username')) {
                $table->dropColumn('username');
            }

            if (Schema::hasColumn('user_cashier', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('user_cashier', 'birthDate')) {
                $table->dropColumn('birthDate');
            }

            if(Schema::hasColumn('user_cashier', 'gender')) {
                $table->dropColumn('gender');
            }

            if(Schema::hasColumn('user_cashier', 'picture')) {
                $table->dropColumn('picture');
            }

            if(Schema::hasColumn('user_cashier', 'address')) {
                $table->dropColumn('address');
            }

            if(Schema::hasColumn('user_cashier', 'phone')) {
                $table->dropColumn('phone');
            }

            if(Schema::hasColumn('user_cashier', 'status')) {
                $table->dropColumn('status');
            }
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
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('gender');
            $table->string('picture')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->nullable();
        });
    }
};
