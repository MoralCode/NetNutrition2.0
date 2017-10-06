<?php

namespace App\Http\Controllers;

use App\Food;

class FoodController extends ApiController
{
    /**
     * returns all the food items
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Food::all();
    }
    /**
     * @param $id
     * returns one food item
     * @return Food|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        return Food::findOrFail($id);
    }

    /**
     * @param $id
     * returns nutritions of a specific food
     * @return mixed
     */
    public function showNutritions($id)
    {
        return Food::findorfail($id)
            ->nutritions;
    }

    /**
     * @param $id
     * returns ingredients of a specific food
     * @return mixed
     */
    public function showIngredients($id)
    {
        return Food::findorfail($id)
            ->ingredients;
    }
}