<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_nutrition', function (Blueprint $table) {
            $table->unsignedInteger('food_id');
            $table->unsignedInteger('nutrition_id');
            $table->foreign('food_id')
                ->references('id')
                ->on('foods');
            $table->foreign('nutrition_id')
                ->references('id')
                ->on('nutritions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_nutrition');
    }
}
