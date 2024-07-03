<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->boolean('subscribe')->default(0);
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')
                  ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('menu_id')->references('id')->on('menus')
                  ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('roles_menus');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
