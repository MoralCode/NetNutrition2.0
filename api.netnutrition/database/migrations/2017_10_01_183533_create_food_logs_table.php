<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('food_id');
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('user_id');
            $table->foreign('food_id')
                ->references('id')
                ->on('foods');
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('food_logs');
    }
}
